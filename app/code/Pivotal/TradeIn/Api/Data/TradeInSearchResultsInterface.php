<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api\Data;

interface TradeInSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get trade_in list.
     *
     * @return \Pivotal\TradeIn\Api\Data\TradeInInterface[]
     */
    public function getItems();

    /**
     * Set firstname list.
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

