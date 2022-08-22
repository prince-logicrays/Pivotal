<?php

namespace Pivotal\TradeIn\Block\Adminhtml\TradeIn\View;

use Magento\Backend\Block\Widget\Context;

/**
 * Undocumented class
 */
class BackButton extends \Magento\Backend\Block\Widget\Container
{
    /**
     * Undocumented function
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_objectId = 'trade_in_id';
        $this->_blockGroup = 'Pivotal_TradeIn';
        $this->_controller = 'adminhtml_TradeIn';
        $this->_mode = 'view';

        $this->addButton(
            'tradein_backbutton',
            [
                'label' => __('Back'),
                'class' => 'back',
                'onclick' => 'setLocation(\'' . $this->getViewPageUrl() . '\')',
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getViewPageUrl()
    {
        return $this->getUrl('tradein/tradein/index');
    }
}
