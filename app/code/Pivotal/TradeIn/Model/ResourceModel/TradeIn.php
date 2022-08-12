<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TradeIn extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('trade_in', 'trade_in_id');
    }
}
