<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Api\Data;

interface TradeInItemInterface
{

    public const TRADE_IN_ITEM_ID = 'trade_in_item_id';
    public const TRADE_IN_ID = 'trade_in_id';
    public const SKU = 'sku';
    public const PRODUCT_NAME = 'product_name';
    public const PRICE = 'price';
    public const PRODUCT_ID = 'product_id';
    public const CONDITION = 'condition';
    public const QTY = 'qty';
    public const SUBTOTAL = 'subtotal';

    /**
     * Get trade_in_item_id
     *
     * @return string|null
     */
    public function getTradeInItemId();

    /**
     * Set trade_in_item_id
     *
     * @param string $tradeInItemId
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setTradeInItemId($tradeInItemId);

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
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setTradeInId($tradeInId);

    /**
     * Get product_id
     *
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     *
     * @param string $productId
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setProductId($productId);

    /**
     * Get product_name
     *
     * @return string|null
     */
    public function getProductName();

    /**
     * Set product_name
     *
     * @param string $productName
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setProductName($productName);

    /**
     * Get sku
     *
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     *
     * @param string $sku
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setSku($sku);

    /**
     * Get price
     *
     * @return string|null
     */
    public function getPrice();

    /**
     * Set price
     *
     * @param string $price
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setPrice($price);

    /**
     * Get condition
     *
     * @return string|null
     */
    public function getCondition();

    /**
     * Set condition
     *
     * @param string $condition
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setCondition($condition);

    /**
     * Get qty
     *
     * @return string|null
     */
    public function getQty();

    /**
     * Set qty
     *
     * @param string $qty
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setQty($qty);

    /**
     * Get subtotal
     *
     * @return string|null
     */
    public function getSubtotal();

    /**
     * Set subtotal
     *
     * @param string $subtotal
     * @return \Pivotal\TradeIn\TradeInItem\Api\Data\TradeInItemInterface
     */
    public function setSubtotal($subtotal);
}
