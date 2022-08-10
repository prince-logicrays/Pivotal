<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Model;

use Pivotal\TradeInPricing\Api\Data\TradeInPricingInterface;

class TradeInPricing extends \Magento\Framework\Model\AbstractModel implements TradeInPricingInterface
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Pivotal\TradeInPricing\Model\ResourceModel\TradeInPricing::class);
    }

    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set EntityId
     *
     * @param int $entityId
     * @return int
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get productCondition.
     *
     * @return string
     */
    public function getProductCondition()
    {
        return $this->getData(self::PRODUCT_CONDITION);
    }

   /**
    * Set productCondition
    *
    * @param string $productCondition
    * @return string
    */
    public function setProductCondition($productCondition)
    {
        return $this->setData(self::PRODUCT_CONDITION, $productCondition);
    }

    /**
     * Get Value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**
     * Set Value
     *
     * @param int $value
     * @return int
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }

    /**
     * Get Status.
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Status
     *
     * @param boolean $status
     * @return boolean
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
