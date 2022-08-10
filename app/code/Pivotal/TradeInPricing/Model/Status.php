<?php

namespace Pivotal\TradeInPricing\Model;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get option
     *
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['1' => __('Yes'),'0' => __('No')];
        return $options;
    }

    /**
     * Get all option
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * Get to option
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
