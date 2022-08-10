<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Controller\Adminhtml\TradeInPricing;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;
use Pivotal\TradeInPricing\Model\ResourceModel\TradeInPricing as DataResourceModel;
use Magento\Framework\App\Action\HttpPostActionInterface;

class InlineEdit extends Action implements HttpPostActionInterface
{
    /**
     * @var jsonFactory
     */
    protected $jsonFactory;

    /**
     * @var tradeinpricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @var dataResourceModel
     */
    private $dataResourceModel;

    /**
     *
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param TradeInPricingFactory $tradeinpricingFactory
     * @param DataResourceModel $dataResourceModel
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        TradeInPricingFactory $tradeinpricingFactory,
        DataResourceModel $dataResourceModel
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->tradeinpricingFactory = $tradeinpricingFactory;
        $this->dataResourceModel = $dataResourceModel;
    }

    /**
     * In-line Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (empty($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $entityId) {
                    $model = $this->tradeinpricingFactory->create();
                    $this->dataResourceModel->load($model, $entityId);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$entityId]));
                        $this->dataResourceModel->save($model);
                    } catch (\Exception $e) {
                        $messages[] = "[Error: {$entityId}] {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Check Inline Edit Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeInPricing::inlineedit');
    }
}
