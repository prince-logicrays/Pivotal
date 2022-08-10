<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Controller\Adminhtml\TradeInPricing;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class AddForm extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Add Form action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Trade-In Pricing Form'));

        return $resultPage;
    }

    /**
     * Check Add Form Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeInPricing::addform');
    }
}
