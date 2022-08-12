<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api\Data;

interface TradeInAddressInterface
{
    public const TRADE_IN_ID = 'trade_in_id';
    public const POSTCODE = 'postcode';
    public const TRADE_IN_ADDRESS_ID = 'trade_in_address_id';
    public const STREET = 'street';
    public const REGION_ID = 'region_id';
    public const ADDRESS_TYPE = 'address_type';
    public const CITY = 'city';
    public const COUNTRY_ID = 'country_id';
    public const REGION = 'region';
    
    /**
     * Get trade_in_address_id
     *
     * @return string|null
     */
    public function getTradeInAddressId();

    /**
     * Set trade_in_address_id
     *
     * @param string $tradeInAddressId
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setTradeInAddressId($tradeInAddressId);

    /**
     * Get trade_in_id
     *
     * @return string|null
     */
    public function getTradeInId();

    /**
     * Set trade_in_id
     *
     * @param string $tradeInId
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setTradeInId($tradeInId);

    /**
     * Get address_type
     *
     * @return string|null
     */
    public function getAddressType();

    /**
     * Set address_type
     *
     * @param string $addressType
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setAddressType($addressType);

    /**
     * Get street
     *
     * @return string|null
     */
    public function getStreet();

    /**
     * Set street
     *
     * @param string $street
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setStreet($street);

    /**
     * Get city
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set city
     *
     * @param string $city
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setCity($city);

    /**
     * Get postcode
     *
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setPostcode($postcode);

    /**
     * Get region_id
     *
     * @return string|null
     */
    public function getRegionId();

    /**
     * Set region_id
     *
     * @param string $regionId
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setRegionId($regionId);

    /**
     * Get region
     *
     * @return string|null
     */
    public function getRegion();

    /**
     * Set region
     *
     * @param string $region
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setRegion($region);

    /**
     * Get country_id
     *
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set country_id
     *
     * @param string $countryId
     * @return \Pivotal\TradeIn\TradeInAddress\Api\Data\TradeInAddressInterface
     */
    public function setCountryId($countryId);
}
