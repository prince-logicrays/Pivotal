<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model;

use Magento\Framework\Model\AbstractModel;
use Pivotal\TradeIn\Api\Data\TradeInInterface;

class TradeIn extends AbstractModel implements TradeInInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Pivotal\TradeIn\Model\ResourceModel\TradeIn::class);
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
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * @inheritDoc
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getPhoneNumber()
    {
        return $this->getData(self::PHONE_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setPhoneNumber($phoneNumber)
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * @inheritDoc
     */
    public function getShippingMethodCode()
    {
        return $this->getData(self::SHIPPING_METHOD_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setShippingMethodCode($shippingMethodCode)
    {
        return $this->setData(self::SHIPPING_METHOD_CODE, $shippingMethodCode);
    }

    /**
     * @inheritDoc
     */
    public function getShippingMethodTitle()
    {
        return $this->getData(self::SHIPPING_METHOD_TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setShippingMethodTitle($shippingMethodTitle)
    {
        return $this->setData(self::SHIPPING_METHOD_TITLE, $shippingMethodTitle);
    }

    /**
     * @inheritDoc
     */
    public function getCollectionDate()
    {
        return $this->getData(self::COLLECTION_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setCollectionDate($collectionDate)
    {
        return $this->setData(self::COLLECTION_DATE, $collectionDate);
    }

    /**
     * @inheritDoc
     */
    public function getNumberOfParcels()
    {
        return $this->getData(self::NUMBER_OF_PARCELS);
    }

    /**
     * @inheritDoc
     */
    public function setNumberOfParcels($numberOfParcels)
    {
        return $this->setData(self::NUMBER_OF_PARCELS, $numberOfParcels);
    }

    /**
     * @inheritDoc
     */
    public function getArrangeFreeShipping()
    {
        return $this->getData(self::ARRANGE_FREE_SHIPPING);
    }

    /**
     * @inheritDoc
     */
    public function setArrangeFreeShipping($arrangeFreeShipping)
    {
        return $this->setData(self::ARRANGE_FREE_SHIPPING, $arrangeFreeShipping);
    }

    /**
     * @inheritDoc
     */
    public function getGrandTotal()
    {
        return $this->getData(self::GRAND_TOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setGrandTotal($grandTotal)
    {
        return $this->setData(self::GRAND_TOTAL, $grandTotal);
    }

    /**
     * @inheritDoc
     */
    public function getTradeinCurrencyCode()
    {
        return $this->getData(self::TRADEIN_CURRENCY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setTradeinCurrencyCode($tradeinCurrencyCode)
    {
        return $this->setData(self::TRADEIN_CURRENCY_CODE, $tradeinCurrencyCode);
    }

    /**
     * @inheritDoc
     */
    public function getTotalItemCount()
    {
        return $this->getData(self::TOTAL_ITEM_COUNT);
    }

    /**
     * @inheritDoc
     */
    public function setTotalItemCount($totalItemCount)
    {
        return $this->setData(self::TOTAL_ITEM_COUNT, $totalItemCount);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getStoreName()
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setStoreName($storeName)
    {
        return $this->setData(self::STORE_NAME, $storeName);
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }

    /**
     * @inheritDoc
     */
    public function getRemoteIp()
    {
        return $this->getData(self::REMOTE_IP);
    }

    /**
     * @inheritDoc
     */
    public function setRemoteIp($remoteIp)
    {
        return $this->setData(self::REMOTE_IP, $remoteIp);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
