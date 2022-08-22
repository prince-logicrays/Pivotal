<?php

namespace Pivotal\TradeIn\Block\Adminhtml\TradeIn\View;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Pivotal\TradeIn\Model\TradeInFactory;
use Pivotal\TradeIn\Model\TradeInAddressFactory;
use Pivotal\TradeIn\Model\TradeInItemFactory;
use Magento\Framework\Pricing\Helper\Data;

class Info extends \Magento\Backend\Block\Template
{
    /**
     * @var TradeInFactory
     */
    public $tradeinFactory;

    /**
     * @var TradeInAddressFactory
     */
    public $tradeinaddressFactory;

    /**
     * @var TradeInItemFactory
     */
    public $tradeinitemFactory;

    /**
     * @var Data
     */
    protected $priceHelper;

    /**
     * @param Context $context
     * @param ProductFactory $product
     * @param TradeInFactory $tradeinFactory
     * @param TradeInAddressFactory $tradeinaddressFactory
     * @param TradeInItemFactory $tradeinitemFactory
     * @param Data $priceHelper
     */
    public function __construct(
        Context $context,
        ProductFactory $product,
        TradeInFactory $tradeinFactory,
        TradeInAddressFactory $tradeinaddressFactory,
        TradeInItemFactory $tradeinitemFactory,
        Data $priceHelper
    ) {
        $this->product = $product;
        $this->tradeinFactory = $tradeinFactory;
        $this->tradeinaddressFactory = $tradeinaddressFactory;
        $this->tradeinitemFactory = $tradeinitemFactory;
        $this->priceHelper = $priceHelper;
        parent::__construct($context);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getRequest()->getParams();
    }

    /**
     * Get Trade In data
     *
     * @return array
     */
    public function getTradeInFactory()
    {
        $CurrentUrl = $this->getRequest()->getParams();
        $TradeInFactory = $this->tradeinFactory->create()->load($CurrentUrl);

        return $TradeInFactory;
    }

    /**
     * Get Trade In Address data
     *
     * @return array
     */
    public function getTradeInAddressFactory()
    {
        $CurrentUrl = $this->getRequest()->getParams();
        $TradeInAddressFactory =  $this->tradeinaddressFactory->create()->load($CurrentUrl);

        return $TradeInAddressFactory;
    }

    /**
     * Get Trade In Item data
     *
     * @return array
     */
    public function getTradeInItemFactory()
    {
        $CurrentUrl = $this->getRequest()->getParams();
        $TradeInItemFactory = $this->tradeinitemFactory->create()->load($CurrentUrl);

        return $TradeInItemFactory;
    }

    /**
     * Get price format with currency
     *
     * @param price $price
     * @return array
     */
    public function getFormattedPrice($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
