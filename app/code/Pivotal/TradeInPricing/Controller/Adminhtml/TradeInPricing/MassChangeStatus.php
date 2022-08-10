<?php

declare(strict_types=1);

namespace Pivotal\TradeInPricing\Controller\Adminhtml\TradeInPricing;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;
use Pivotal\TradeInPricing\Model\ResourceModel\TradeInPricing\CollectionFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

class MassChangeStatus extends Action implements HttpPostActionInterface
{
    /**
     * @var filter
     */
    protected $filter;

    /**
     * @var resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @var collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var tradeinpricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @var logger
     */
    protected $logger;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Filter $filter
     * @param TradeInPricingFactory $tradeinpricingFactory
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Filter $filter,
        TradeInPricingFactory $tradeinpricingFactory,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->tradeinpricingFactory = $tradeinpricingFactory;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
    }

    /**
     * Mass Change Status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $updated = 0;
            foreach ($collection as $item) {
                $model = $this->tradeinpricingFactory->create()->load($item['entity_id']);
                $model->setData('status', $this->getRequest()->getParam('status'));
                $model->save();
                $updated++;
            }
            if ($updated) {
                $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $updated));
            }

        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    /**
     * Check Mass Change Status Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pivotal_TradeInPricing::masschangestatus');
    }
}
