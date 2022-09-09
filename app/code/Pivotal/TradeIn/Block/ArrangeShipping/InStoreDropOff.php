<?php

namespace Pivotal\TradeIn\Block\ArrangeShipping;

use Magento\Framework\View\Element\Template;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;

class InStoreDropOff extends Template
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
}
