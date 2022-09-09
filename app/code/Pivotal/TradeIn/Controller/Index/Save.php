<?php

namespace Pivotal\TradeIn\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Pivotal\TradeIn\Helper\Email;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Save extends Action implements HttpGetActionInterface
{
    /**
     * @var Email
     */
    protected $email;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $resultJsonFactory;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $scopeConfig;

    public const XML_PATH_EMAIL_RECIPIENT = 'trade_in_form/trade_in/recipient_email';

    /**
     * @param Context $context
     * @param Email $email
     * @param JsonFactory $resultJsonFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        Email $email,
        JsonFactory $resultJsonFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->email = $email;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getReceipentEmail()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope);
    }

    /**
     * Trade-in send email
     *
     * @return void
     */
    public function execute()
    {
        echo "Email Sent";
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $result = $this->resultJsonFactory->create();
        $block = $page->getLayout()->getBlock('tradein.index.save');

        $templateVars = [
            "id" => 1,
            "firstname" => "Dipak",
            "lastname" => "prajapati",
            "email" => "prince@logicrays.com",
            "phonenumber" => "09876543210",
            "payment_method" => "Check / Money order",
            "shipping_method" => "Flat Rate - Fixed",
            "itemsData" => [
                "cartItemsData" => [
                    [
                        "itemId" => "0", 
                        "productName" => "Hello",
                        "product_id" => "", 
                        "item_note" => "We currently are unable to quote online for this store, however a member of our team will be touch in with a quote as soon as possible                                                ", 
                        "item_condition_id" => "2", 
                        "item_condition" => "Mint", 
                        "item_qty" => "2", 
                        "sku" => "34-PB09", 
                        "product_price" => null, 
                        "product_url" => null, 
                        "formatted_price" => "$69.00",
                        "thumbnail_url" => "http://127.0.0.1/m243/pub/static/version1662016491/frontend/Magento/luma/en_US/Magento_Catalog/images/product/placeholder/thumbnail.jpg", 
                        "trade_in_price_value" => "15", 
                        "product_tradein_price" => "0.0000", 
                        "product_tradein_formatted_price" => "TBC", 
                        "subtotal" => "TBC", 
                        "subtotalWithoutCurrencySymbol" => "0.0000" 
                    ],
                    [
                        "itemId" => "0", 
                        "productName" => "Trade in",
                        "product_id" => "", 
                        "item_note" => "We currently are unable to quote online for this store, however a member of our team will be touch in with a quote as soon as possible                                                ", 
                        "item_condition_id" => "2", 
                        "item_condition" => "Good", 
                        "item_qty" => "3", 
                        "sku" => "56-BM20",
                        "product_price" => null, 
                        "product_url" => null, 
                        "formatted_price" => "$159.00",
                        "thumbnail_url" => "http://127.0.0.1/m243/pub/static/version1662016491/frontend/Magento/luma/en_US/Magento_Catalog/images/product/placeholder/thumbnail.jpg", 
                        "trade_in_price_value" => "15", 
                        "product_tradein_price" => "0.0000", 
                        "product_tradein_formatted_price" => "TBC", 
                        "subtotal" => "TBC", 
                        "subtotalWithoutCurrencySymbol" => "0.0000" 
                    ],
                    [
                        "itemId" => "1", 
                        "productName" => " Fusion Backpack", 
                        "product_id" => "6", 
                        "item_note" => "", 
                        "item_condition_id" => "2", 
                        "item_condition" => "Excellent", 
                        "item_qty" => "1", 
                        "sku" => "24-MB02", 
                        "product_price" => "59.0000", 
                        "product_url" => "http://127.0.0.1/m243/fusion-backpack.html", 
                        "formatted_price" => "$59.00", 
                        "thumbnail_url" => "http://127.0.0.1/m243/pub/media/catalog/product/cache/3fd251faa844f4d994194401d32a5e9d/m/b/mb02-gray-0.jpg", 
                        "trade_in_price_value" => "15", 
                        "product_tradein_price" => 8.85, 
                        "product_tradein_formatted_price" => "$8.85", 
                        "subtotal" => "$8.85", 
                        "subtotalWithoutCurrencySymbol" => 8.85 
                    ] 
                ], 
                "grandTotal" => 8.85, 
                "grandTotalWithCurrency" => "$8.85" 
            ],
            "collection_date" => "09/01/2022 16:01:59", 
            "number_of_parcels" => "5", 
            "arrange_free_shipping" => "dpd_home_collection",
            "shipping_method_title" => "Book your free shipping",
            "shipping_method_code" => "book_your_free_shipping",
            "collection_address" => "different_to_home_address", 
            "select_home_address" => "4", 
            "home_address" => [
                "street_1" => "B-602, Safal Pegasus, Prahladnagar,", 
                "street_2" => null, 
                "street_3" => null, 
                "street_4" => null, 
                "country_id" => "IN", 
                "country_name" => "India", 
                "region_id" => null, 
                "region_name" => "Gujarat,", 
                "city" => "Ahmedabad, ", 
                "zip" => "380015" 
            ],
            "select_different_address" => "9", 
            "different_address" => [
                "street_1" => "26, S.T Society-2 , Chitra sidsar road, chitra", 
                "street_2" => null, 
                "street_3" => null, 
                "street_4" => null, 
                "country_id" => "IN", 
                "country_name" => "India", 
                "region_id" => null, 
                "region_name" => "Gujarat", 
                "city" => "bhavnagr, ", 
                "zip" => "36004" 
            ],
            "arrange_free_shipping_title" => "DPD Home Collection"
        ];

        $setData = ['hello', 'world'];

        $block = $page->getLayout()
            ->createBlock(\Pivotal\TradeIn\Block\Email::class)
            ->setTemplate('Pivotal_TradeIn::email/product.phtml')
            ->setData('items', $setData)
            ->toHtml();

        $result->setData(['items' => $block]);

        $adminEmail = $this->getReceipentEmail();

        $customerEmail = $templateVars['email'];

        $this->email->sendEmailToCustomer($templateVars, $customerEmail);
        $this->email->sendEmailToAdmin($templateVars, $adminEmail);
    }
}
