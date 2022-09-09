<?php

namespace Pivotal\TradeIn\Block\Adminhtml\TradeIn\View;

use Magento\Backend\Block\Widget\Context;
use Pivotal\TradeIn\Model\TradeInFactory;
use Pivotal\TradeIn\Model\TradeInAddressFactory;
use Pivotal\TradeIn\Model\TradeInItemFactory;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;

class Info extends \Magento\Backend\Block\Widget\Container
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
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Context $context
     * @param TradeInFactory $tradeinFactory
     * @param TradeInAddressFactory $tradeinaddressFactory
     * @param TradeInItemFactory $tradeinitemFactory
     * @param Data $priceHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        TradeInFactory $tradeinFactory,
        TradeInAddressFactory $tradeinaddressFactory,
        TradeInItemFactory $tradeinitemFactory,
        Data $priceHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->tradeinFactory = $tradeinFactory;
        $this->tradeinaddressFactory = $tradeinaddressFactory;
        $this->tradeinitemFactory = $tradeinitemFactory;
        $this->priceHelper = $priceHelper;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Add back button
     *
     * @return string
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_objectId = 'trade_in_id';
        $this->_blockGroup = 'Pivotal_TradeIn';
        $this->_controller = 'adminhtml_TradeIn';
        $this->_mode = 'view';

        $this->addButton(
            'tradein_backbutton',
            [
                'label' => __('Back'),
                'class' => 'back',
                'onclick' => 'setLocation(\'' . $this->getViewPageUrl() . '\')',
            ]
        );

        $this->addButton(
            'delete',
            [
                'label' => __('Delete'),
                'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
                    . ','
                    . json_encode($this->getDeleteUrl())
                    . ')',
                'class' => 'scalable delete',
                'level' => -1
            ]
        );
    }

    /**
     * Get view page url
     *
     * @return string
     */
    public function getViewPageUrl()
    {
        return $this->getUrl('tradein/tradein/index');
    }

    /**
     * Get delete url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('tradein/tradein/delete'.'/trade_in_id/'.$this->getId());
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getRequest()->getParam("trade_in_id");
    }

    /**
     * Get Trade In data
     *
     * @return array
     */
    public function getTradeInData()
    {
        $tradeInId = $this->getId();
        $tradeInData = $this->tradeinFactory->create()->load($tradeInId);
        return $tradeInData;
    }

    /**
     * Get Trade In Address
     *
     * @return array
     */
    public function getTradeInBillingAddress()
    {
        $tradeInId = $this->getId();
        $tradeInBillingAddress = $this->tradeinaddressFactory->create()
                                ->getCollection()
                                ->addFieldToFilter('trade_in_id', $tradeInId)
                                ->addFieldToFilter('address_type', 'billing')
                                ->getFirstItem();

        return $tradeInBillingAddress;
    }

    /**
     * Get Trade In Shipping Address
     *
     * @return array
     */
    public function getTradeInShippingAddress()
    {
        $tradeInId = $this->getId();
        $tradeInShippingAddress = $this->tradeinaddressFactory->create()
                                ->getCollection()
                                ->addFieldToFilter('trade_in_id', $tradeInId)
                                ->addFieldToFilter('address_type', 'shipping')
                                ->getFirstItem();

        return $tradeInShippingAddress;
    }

    /**
     * Get Trade In Item data
     *
     * @return array
     */
    public function getTradeInItems()
    {
        $tradeInId = $this->getId();
        $tradeInShippingAddress = $this->tradeinitemFactory->create()
                                ->getCollection()
                                ->addFieldToFilter('trade_in_id', $tradeInId);

        return $tradeInShippingAddress;
    }

    /**
     * Get website and store name by id
     *
     * @return array
     */
    public function getStore()
    {
        $storeId = $this->getTradeInData()->getStoreId();
        if ($storeId === null) {
            $deleted = __(' [deleted]');
            return nl2br($this->getTradeInData()->getStoreName()) . $deleted;
        }
            $store = $this->_storeManager->getStore($storeId);
            $name = [$store->getWebsite()->getName(), $store->getGroup()->getName(), $store->getName()];
            return implode('<br/>', $name);
    }

    /**
     * Get price format with currency
     *
     * @param float $price
     * @return string
     */
    public function getFormattedPrice($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
