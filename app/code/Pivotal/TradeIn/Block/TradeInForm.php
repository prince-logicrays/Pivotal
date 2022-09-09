<?php

namespace Pivotal\TradeIn\Block;

use Magento\Framework\View\Element\Template;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;

class TradeInForm extends Template
{
    /**
     * @var TradeInPricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @param Template\Context $context
     * @param TradeInPricingFactory $tradeinpricingFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TradeInPricingFactory $tradeinpricingFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->tradeinpricingFactory = $tradeinpricingFactory;
        $this->_isScopePrivate = true;
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('trade_in/index/post', ['_secure' => true]);
    }

    /**
     * Get conditions
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->tradeinpricingFactory->create()
                    ->getCollection()
                    ->addFieldToFilter("status", 1);
    }

    /**
     * GetConditionGuideUrl
     *
     * @return string
     */
    public function getConditionGuideUrl() {
        return $this->getUrl('used-descriptions');
    }
}
