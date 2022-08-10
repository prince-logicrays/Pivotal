<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Controller\Adminhtml\TradeInPricing;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var TradeInPricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @param Context $context
     * @param TradeInPricingFactory $tradeinpricingFactory
     */
    public function __construct(
        Context $context,
        TradeInPricingFactory $tradeinpricingFactory
    ) {
        parent::__construct($context);
        $this->tradeinpricingFactory = $tradeinpricingFactory;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        try {
            $id = $this->getRequest()->getParam('entity_id');
            $model = $this->tradeinpricingFactory->create();

            if ($id) {
                $model->load($id);

                $model->setData([
                "entity_id" => $id,
                "product_condition" => $data['product_condition'],
                "value" => $data['value'],
                "status" => $data['status'],
                ]);

                $editData = $model->save();

                if ($editData) {
                    $this->messageManager->addSuccess(__('Edit data Successfully !'));
                }
            } else {
                $model->addData([
                "product_condition" => $data['product_condition'],
                "value" => $data['value'],
                "status" => $data['status'],
                ]);

                $saveData = $model->save();

                if ($saveData) {
                    $this->messageManager->addSuccess(__('Insert data Successfully !'));
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
            $this->_redirect('*/*/index');
    }

    /**
     * Check save Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeInPricing::save');
    }
}
