<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Api\Data;

interface TradeInPricingInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'entity_id';
    public const PRODUCT_CONDITION = 'product_condition';
    public const VALUE = 'value';
    public const STATUS = 'status';

    /**
     * Get entityid.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set entityid
     *
     * @param int $entityId
     * @return \Pivotal\TradeInPricing\Api\Data\TradeInPricingInterface
     */
    public function setEntityId($entityId);

    /**
     * Get condition.
     *
     * @return string
     */
    public function getProductCondition();

    /**
     * Set productCondition
     *
     * @param string $productCondition
     * @return \Pivotal\TradeInPricing\Api\Data\TradeInPricingInterface
     */
    public function setProductCondition($productCondition);

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue();

    /**
     * Set value
     *
     * @param int $value
     * @return \Pivotal\TradeInPricing\Api\Data\TradeInPricingInterface
     */
    public function setValue($value);

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param boolean $status
     * @return \Pivotal\TradeInPricing\Api\Data\TradeInPricingInterface
     */
    public function setStatus($status);
}
