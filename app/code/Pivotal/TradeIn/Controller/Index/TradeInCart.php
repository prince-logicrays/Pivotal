<?php
namespace Pivotal\TradeIn\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;
use Magento\Catalog\Helper\ImageFactory as CatalogImageHelper;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class TradeInCart extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var TradeInPricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var CatalogImageHelper
     */
    protected $catalogImageHelper;

    /**
     * @var AssetRepository
     */
    protected $assetRepository;

    /**
     * @var JsonFactory
     */
    protected $jsonResultFactory;

    /**
     * Get cart items function
     *
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param TradeInPricingFactory $tradeinpricingFactory
     * @param PriceCurrencyInterface $priceCurrency
     * @param CatalogImageHelper $catalogImageHelper
     * @param AssetRepository $assetRepository
     * @param JsonFactory $jsonResultFactory
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        TradeInPricingFactory $tradeinpricingFactory,
        PriceCurrencyInterface $priceCurrency,
        CatalogImageHelper $catalogImageHelper,
        AssetRepository $assetRepository,
        JsonFactory $jsonResultFactory
    ) {
        $this->productFactory = $productFactory;
        $this->tradeinpricingFactory = $tradeinpricingFactory;
        $this->priceCurrency = $priceCurrency;
        $this->assetRepository = $assetRepository;
        $this->catalogImageHelper = $catalogImageHelper;
        $this->jsonResultFactory = $jsonResultFactory;
        return parent::__construct($context);
    }

    /**
     * Get cart items execute function
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $cartItems = $this->getRequest()->getPost('cartItems');

        $cartItemsData = $temp = [];
        $grandtotal = null;

        foreach ($cartItems as $item) {
            $product_price = $formatted_price = $thumbnail_url = $sku = $product_url = null ;
            $product_tradein_formatted_price = $product_tradein_price = $subtotal = null;
            $subtotalWithoutCurrencySymbol = null;
            $qty = $item['item_qty']?$item['item_qty']:1;

            // If trade-in cart has product
            if (!empty($item['product_id'])) {
                // Load product by product id
                $product = $this->productFactory->create()->load($item['product_id']);
                $product_url = $product->getProductUrl();
                // Get product price
                $product_price = number_format($product->getPrice(), 4);

                // Get product formatted price and remove span tags from the price
                $formatted_price = strip_tags($product->getFormattedPrice());
                
                // Get product sku
                $sku = $product->getSku();
                // Get product thumbnail image url
                if (!empty($product->getThumbnail())) {
                    $thumbnail_url = $this->getThumbnailImageUrl($product);
                } else {
                    $thumbnail_url = $this->getPlaceHolderImage();
                }

                // TradeIn price calucaluation
                $product_tradein_price = $this->calculateTradeInPrice($product_price, $item['item_condition_id']);
                $product_tradein_formatted_price = $this->getCurrencyWithFormat($product_tradein_price);

                // Get subtotal
                $subtotalWithoutCurrencySymbol = $product_tradein_price * $qty;
                $subtotal = $this->getCurrencyWithFormat($subtotalWithoutCurrencySymbol);
            } else {
                $product_tradein_price = number_format(0, 4);
                $product_tradein_formatted_price = "TBC";
                $thumbnail_url = $this->getPlaceHolderImage();
                $subtotal = "TBC";
                $subtotalWithoutCurrencySymbol = number_format(0, 4);
            }
            
            $grandtotal = $grandtotal + $subtotalWithoutCurrencySymbol;
            $temp = $item;
            $temp['sku'] = $sku;
            $temp['product_price'] = $product_price;
            $temp['product_url'] = $product_url;
            $temp['formatted_price'] = $formatted_price;
            $temp['item_qty'] = $qty;
            $temp['thumbnail_url'] = $thumbnail_url;
            $temp['trade_in_price_value'] = $this->getTradeInPriceValue($item['item_condition_id']);
            $temp['product_tradein_price'] = $product_tradein_price;
            $temp['product_tradein_formatted_price'] = $product_tradein_formatted_price;
            $temp['subtotal'] = $subtotal;
            $temp['subtotalWithoutCurrencySymbol'] = $subtotalWithoutCurrencySymbol;

            $cartItemsData [] = $temp;
        }
        
        $data = [
            'cartItemsData' => $cartItemsData,
            'grandTotal' => $grandtotal,
            'grandTotalWithCurrency' => $this->getCurrencyWithFormat($grandtotal)
        ];
        
        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        return $result;
    }

    /**
     * Price format function
     *
     * @param float $price
     * @return void
     */
    protected function getCurrencyWithFormat($price)
    {
        return strip_tags($this->priceCurrency->convertAndFormat($price));
    }

    /**
     * Get image url
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    protected function getThumbnailImageUrl($product)
    {
        /** @var \Magento\Catalog\Helper\Image $helper */
        $imageHelper = $this->catalogImageHelper->create();
        $thumbnailImageUrl = $imageHelper->init($product, 'product_thumbnail_image')->getUrl();
        return $thumbnailImageUrl;
    }
    
    /**
     * Get small place holder image
     *
     * @return string
     */
    protected function getPlaceHolderImage()
    {
        /** @var \Magento\Catalog\Helper\Image $helper */
        $imageHelper = $this->catalogImageHelper->create();
        return $this->assetRepository->getUrl($imageHelper->getPlaceholder('thumbnail'));
    }

    /**
     * Get trade-in price value
     *
     * @param int $condition_id
     * @return float
     */
    protected function getTradeInPriceValue($condition_id)
    {
        // Load tradeInPrice model by condition_id
        $tradeInPrice = $this->tradeinpricingFactory->create()->load($condition_id);
        // Get tradeInPrice value
        return $tradeInPrice->getValue();
    }

    /**
     * Calculate trade-in price
     *
     * @param float $product_price
     * @param int $condition_id
     * @return float
     */
    protected function calculateTradeInPrice($product_price, $condition_id)
    {
        $pricecalculate = null;
        // Get trade-in price value
        $tradeInPriceValue = $this->getTradeInPriceValue($condition_id);
        // Get tradeInPrice value and calculate
        $pricecalculate = ($product_price * $tradeInPriceValue)/100;
        return $pricecalculate;
    }
}
