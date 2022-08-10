<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Controller\Adminhtml\TradeInPricing;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class EditForm extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Edit Form action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Trade-In Pricing List'));

        return $resultPage;
    }

    /**
     * Check edit form Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeInPricing::editform');
    }
}
