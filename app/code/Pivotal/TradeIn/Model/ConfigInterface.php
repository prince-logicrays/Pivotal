<?php
namespace Pivotal\TradeIn\Model;

interface ConfigInterface
{
    /**
     * Enabled config path
     */
    public const XML_PATH_ENABLED = 'trade_in_form/trade_in/enabled';
    public const XML_PATH_BOOK_YOUR_FREE_SHIPPING_DESC = 'trade_in_form/trade_in/free_shipping_description';

    /**
     * Check if tradeInForm module is enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get book your free shipping description
     *
     * @return bool
     */
    public function getBookYourFreeShippingDescription();
}
