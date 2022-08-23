<?php

declare(strict_types=1);

namespace Pivotal\TradeIn\Controller\Adminhtml\TradeIn;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * Grid List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        // /* @var \Magento\Backend\Model\View\Result\Page $resultPage /
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Pivotal_TradeIn::tradein_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Trade-In List'));

        return $resultPage;
    }
    
    /**
     * Check Trade-In List Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeIn::tradein_list');
    }
}
