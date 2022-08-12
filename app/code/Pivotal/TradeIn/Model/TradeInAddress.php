<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model;

use Magento\Framework\Model\AbstractModel;
use Pivotal\TradeIn\Api\Data\TradeInAddressInterface;

class TradeInAddress extends AbstractModel implements TradeInAddressInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Pivotal\TradeIn\Model\ResourceModel\TradeInAddress::class);
    }

    /**
     * @inheritDoc
     */
    public function getTradeInAddressId()
    {
        return $this->getData(self::TRADE_IN_ADDRESS_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTradeInAddressId($tradeInAddressId)
    {
        return $this->setData(self::TRADE_IN_ADDRESS_ID, $tradeInAddressId);
    }

    /**
     * @inheritDoc
     */
    public function getTradeInId()
    {
        return $this->getData(self::TRADE_IN_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTradeInId($tradeInId)
    {
        return $this->setData(self::TRADE_IN_ID, $tradeInId);
    }

    /**
     * @inheritDoc
     */
    public function getAddressType()
    {
        return $this->getData(self::ADDRESS_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setAddressType($addressType)
    {
        return $this->setData(self::ADDRESS_TYPE, $addressType);
    }

    /**
     * @inheritDoc
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * @inheritDoc
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * @inheritDoc
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * @inheritDoc
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @inheritDoc
     */
    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * @inheritDoc
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * @inheritDoc
     */
    public function getRegionId()
    {
        return $this->getData(self::REGION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * @inheritDoc
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * @inheritDoc
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * @inheritDoc
     */
    public function getCountryId()
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }
}
