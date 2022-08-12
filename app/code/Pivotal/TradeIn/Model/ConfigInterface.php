<?php
namespace Pivotal\TradeIn\Model;

interface ConfigInterface
{
    /**
     * Enabled config path
     */
    public const XML_PATH_ENABLED = 'trade_in_form/trade_in/enabled';

    /**
     * Check if customForms module is enabled
     *
     * @return bool
     */
    public function isEnabled();
}
