<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TradeInAddressRepositoryInterface
{

    /**
     * Save trade_in_address
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInAddressInterface $tradeInAddress
     * @return \Pivotal\TradeIn\Api\Data\TradeInAddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Pivotal\TradeIn\Api\Data\TradeInAddressInterface $tradeInAddress
    );

    /**
     * Retrieve trade_in_address
     *
     * @param string $tradeInAddressId
     * @return \Pivotal\TradeIn\Api\Data\TradeInAddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($tradeInAddressId);

    /**
     * Retrieve trade_in_address matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Pivotal\TradeIn\Api\Data\TradeInAddressSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete trade_in_address
     *
     * @param \Pivotal\TradeIn\Api\Data\TradeInAddressInterface $tradeInAddress
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Pivotal\TradeIn\Api\Data\TradeInAddressInterface $tradeInAddress
    );

    /**
     * Delete trade_in_address by ID
     *
     * @param string $tradeInAddressId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($tradeInAddressId);
}
