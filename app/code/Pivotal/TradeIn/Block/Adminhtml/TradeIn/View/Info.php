<?php

namespace Pivotal\TradeIn\Block\Adminhtml\TradeIn\View;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Pivotal\TradeIn\Model\ResourceModel\TradeIn\CollectionFactory as TradeInCollection;
use Pivotal\TradeIn\Model\ResourceModel\TradeInAddress\CollectionFactory as TradeInAddressCollection;
use Pivotal\TradeIn\Model\ResourceModel\TradeInItem\CollectionFactory as TradeInItemCollection;

class Info extends \Magento\Backend\Block\Template
{
    /**
     * @var TradeInCollection
     */
    public $tradeincollection;

    /**
     * @var TradeInAddressCollection
     */
    public $tradeinaddresscollection;

    /**
     * @var TradeInItemCollection
     */
    public $tradeinitemcollection;

    /**
     * @param Context $context
     * @param ProductFactory $product
     * @param TradeInCollection $tradeincollection
     * @param TradeInAddressCollection $tradeinaddresscollection
     * @param TradeInItemCollection $tradeinitemcollection
     */
    public function __construct(
        Context $context,
        ProductFactory $product,
        TradeInCollection $tradeincollection,
        TradeInAddressCollection $tradeinaddresscollection,
        TradeInItemCollection $tradeinitemcollection
    ) {
        $this->product = $product;
        $this->tradeincollection = $tradeincollection;
        $this->tradeinaddresscollection = $tradeinaddresscollection;
        $this->tradeinitemcollection = $tradeinitemcollection;
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
    public function getTradeInCollection()
    {
        return $this->tradeincollection->create();
    }

    /**
     * Get Trade In Address data
     *
     * @return array
     */
    public function getTradeInAddressCollection()
    {
        return $this->tradeinaddresscollection->create();
    }

    /**
     * Get Trade In Item data
     *
     * @return array
     */
    public function getTradeInItemCollection()
    {
        return $this->tradeinitemcollection->create();
    }
}
