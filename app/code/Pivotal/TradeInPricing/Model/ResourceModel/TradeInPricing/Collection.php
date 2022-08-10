<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Model\ResourceModel\TradeInPricing;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Pivotal\TradeInPricing\Model\TradeInPricing::class,
            \Pivotal\TradeInPricing\Model\ResourceModel\TradeInPricing::class
        );
    }
}
