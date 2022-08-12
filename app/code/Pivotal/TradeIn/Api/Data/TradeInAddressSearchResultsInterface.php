<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api\Data;

interface TradeInAddressSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get trade_in_address list.
     *
     * @return \Pivotal\TradeIn\Api\Data\TradeInAddressInterface[]
     */
    public function getItems();

    /**
     * Set trade_in_id list.
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInAddressInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
