<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api\Data;

interface TradeInInterface
{
    public const TRADE_IN_ID = 'trade_in_id';
    public const FIRSTNAME = 'firstname';
    public const LASTNAME = 'lastname';
    public const EMAIL = 'email';
    public const PHONE_NUMBER = 'phone_number';
    public const SHIPPING_METHOD_TITLE = 'shipping_method_title';
    public const STORE_ID = 'store_id';
    public const TOTAL_ITEM_COUNT = 'total_item_count';
    public const SHIPPING_METHOD_CODE = 'shipping_method_code';
    public const COLLECTION_DATE = 'collection_date';
    public const ARRANGE_FREE_SHIPPING = 'arrange_free_shipping';
    public const STORE_NAME = 'store_name';
    public const WEBSITE_ID = 'website_id';
    public const REMOTE_IP = 'remote_ip';
    public const CREATED_AT = 'created_at';
    public const GRAND_TOTAL = 'grand_total';
    public const NUMBER_OF_PARCELS = 'number_of_parcels';
    public const TRADEIN_CURRENCY_CODE = 'tradein_currency_code';

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
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setTradeInId($tradeInId);

    /**
     * Get firstname
     *
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setFirstname($firstname);

    /**
     * Get lastname
     *
     * @return string|null
     */
    public function getLastname();

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setLastname($lastname);

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setEmail($email);

    /**
     * Get phone_number
     *
     * @return string|null
     */
    public function getPhoneNumber();

    /**
     * Set phone_number
     *
     * @param string $phoneNumber
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * Get shipping_method_code
     *
     * @return string|null
     */
    public function getShippingMethodCode();

    /**
     * Set shipping_method_code
     *
     * @param string $shippingMethodCode
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setShippingMethodCode($shippingMethodCode);

    /**
     * Get shipping_method_title
     *
     * @return string|null
     */
    public function getShippingMethodTitle();

    /**
     * Set shipping_method_title
     *
     * @param string $shippingMethodTitle
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setShippingMethodTitle($shippingMethodTitle);

    /**
     * Get collection_date
     *
     * @return string|null
     */
    public function getCollectionDate();

    /**
     * Set collection_date
     *
     * @param string $collectionDate
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setCollectionDate($collectionDate);

    /**
     * Get number_of_parcels
     *
     * @return string|null
     */
    public function getNumberOfParcels();

    /**
     * Set number_of_parcels
     *
     * @param string $numberOfParcels
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setNumberOfParcels($numberOfParcels);

    /**
     * Get arrange_free_shipping
     *
     * @return string|null
     */
    public function getArrangeFreeShipping();

    /**
     * Set arrange_free_shipping
     *
     * @param string $arrangeFreeShipping
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setArrangeFreeShipping($arrangeFreeShipping);

    /**
     * Get grand_total
     *
     * @return string|null
     */
    public function getGrandTotal();

    /**
     * Set grand_total
     *
     * @param string $grandTotal
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setGrandTotal($grandTotal);

    /**
     * Get tradein_currency_code
     *
     * @return string|null
     */
    public function getTradeinCurrencyCode();

    /**
     * Set tradein_currency_code
     *
     * @param string $tradeinCurrencyCode
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setTradeinCurrencyCode($tradeinCurrencyCode);

    /**
     * Get total_item_count
     *
     * @return string|null
     */
    public function getTotalItemCount();

    /**
     * Set total_item_count
     *
     * @param string $totalItemCount
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setTotalItemCount($totalItemCount);

    /**
     * Get store_id
     *
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     *
     * @param string $storeId
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setStoreId($storeId);

    /**
     * Get store_name
     *
     * @return string|null
     */
    public function getStoreName();

    /**
     * Set store_name
     *
     * @param string $storeName
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setStoreName($storeName);

    /**
     * Get website_id
     *
     * @return string|null
     */
    public function getWebsiteId();

    /**
     * Set website_id
     *
     * @param string $websiteId
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Get remote_ip
     *
     * @return string|null
     */
    public function getRemoteIp();

    /**
     * Set remote_ip
     *
     * @param string $remoteIp
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setRemoteIp($remoteIp);

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     *
     * @param string $createdAt
     * @return \Pivotal\TradeIn\TradeIn\Api\Data\TradeInInterface
     */
    public function setCreatedAt($createdAt);
}
