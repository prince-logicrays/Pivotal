<?php

namespace Pivotal\TradeIn\Model\Config\Source;

class ArrangeFreeShippingMethods implements \Magento\Framework\Data\OptionSourceInterface
{

    public const DPD_HOME_COLLECTION = 'dpd_home_collection';
    public const EVRI_DROP_OFF_POINT = 'evri_drop_off_point';

    /**
     * Possible Google Pay button styles
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::DPD_HOME_COLLECTION,
                'label' => __('DPD Home Collection')
            ],
            [
                'value' => self::EVRI_DROP_OFF_POINT,
                'label' => __('Evri Drop Off Point')
            ],
        ];
    }
}
