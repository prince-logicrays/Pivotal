<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TradeInRepositoryInterface
{
    /**
     * Save trade_in
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInInterface $tradeIn
     * @return \Pivotal\TradeIn\Api\Data\TradeInInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Pivotal\TradeIn\Api\Data\TradeInInterface $tradeIn
    );

    /**
     * Retrieve trade_in
     *
     * @param string $tradeInId
     * @return \Pivotal\TradeIn\Api\Data\TradeInInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($tradeInId);

    /**
     * Retrieve trade_in matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Pivotal\TradeIn\Api\Data\TradeInSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete trade_in
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInInterface $tradeIn
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Pivotal\TradeIn\Api\Data\TradeInInterface $tradeIn
    );

    /**
     * Delete trade_in by ID
     *
     * @param string $tradeInId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($tradeInId);
}
