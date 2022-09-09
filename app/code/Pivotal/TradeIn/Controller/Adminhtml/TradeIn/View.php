<?php

declare(strict_types=1);

namespace Pivotal\TradeIn\Controller\Adminhtml\TradeIn;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class View extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * View page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $tradeInId = $this->getRequest()->getParam("trade_in_id");
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Pivotal_TradeIn::trades');
        $resultPage->getConfig()->getTitle()->prepend(__('Trade ID: #'.$tradeInId));
        return $resultPage;
    }

    /**
     * Check view page permission
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeIn::trade_in_view');
    }
}
