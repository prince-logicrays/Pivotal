<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model;

use Magento\Framework\Model\AbstractModel;
use Pivotal\TradeIn\Api\Data\TradeInItemInterface;

class TradeInItem extends AbstractModel implements TradeInItemInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Pivotal\TradeIn\Model\ResourceModel\TradeInItem::class);
    }

    /**
     * @inheritDoc
     */
    public function getTradeInItemId()
    {
        return $this->getData(self::TRADE_IN_ITEM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTradeInItemId($tradeInItemId)
    {
        return $this->setData(self::TRADE_IN_ITEM_ID, $tradeInItemId);
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
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getCondition()
    {
        return $this->getData(self::CONDITION);
    }

    /**
     * @inheritDoc
     */
    public function setCondition($condition)
    {
        return $this->setData(self::CONDITION, $condition);
    }

    /**
     * @inheritDoc
     */
    public function getQty()
    {
        return $this->getData(self::QTY);
    }

    /**
     * @inheritDoc
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    /**
     * @inheritDoc
     */
    public function getSubtotal()
    {
        return $this->getData(self::SUBTOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setSubtotal($subtotal)
    {
        return $this->setData(self::SUBTOTAL, $subtotal);
    }
}
