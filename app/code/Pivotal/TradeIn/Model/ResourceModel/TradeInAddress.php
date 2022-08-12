<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TradeInAddress extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('trade_in_address', 'trade_in_address_id');
    }
}
