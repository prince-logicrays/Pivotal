<?php

namespace Pivotal\TradeIn\Controller\Adminhtml\TradeIn;

use Magento\Backend\App\Action\Context;
use Pivotal\TradeIn\Model\TradeIn;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var TradeIn
     */
    protected $_model;

    /**
     * @param Context $context
     * @param TradeIn $model
     */
    public function __construct(
        Context $context,
        TradeIn $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('trade_in_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted'));
                return $resultRedirect->setPath('tradein/tradein/index/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('tradein/tradein/index/', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check Delete Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeIn::view_page_delete');
    }
}
