<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model\ResourceModel\TradeInAddress;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'trade_in_address_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Pivotal\TradeIn\Model\TradeInAddress::class,
            \Pivotal\TradeIn\Model\ResourceModel\TradeInAddress::class
        );
    }
}
