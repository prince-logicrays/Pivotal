<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TradeInItemRepositoryInterface
{

    /**
     * Save trade_in_item
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInItemInterface $tradeInItem
     * @return \Pivotal\TradeIn\Api\Data\TradeInItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Pivotal\TradeIn\Api\Data\TradeInItemInterface $tradeInItem
    );

    /**
     * Retrieve trade_in_item
     *
     * @param string $tradeInItemId
     * @return \Pivotal\TradeIn\Api\Data\TradeInItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($tradeInItemId);

    /**
     * Retrieve trade_in_item matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Pivotal\TradeIn\Api\Data\TradeInItemSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete trade_in_item
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInItemInterface $tradeInItem
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Pivotal\TradeIn\Api\Data\TradeInItemInterface $tradeInItem
    );

    /**
     * Delete trade_in_item by ID
     *
     * @param string $tradeInItemId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($tradeInItemId);
}
