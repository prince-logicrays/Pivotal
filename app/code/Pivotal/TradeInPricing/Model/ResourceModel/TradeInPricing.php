<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Model\ResourceModel;

/**
 * TradeInPricing mysql resource.
 */
class TradeInPricing extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('pivotal_tradein_pricing', 'entity_id');
    }
}
