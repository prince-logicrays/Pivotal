<?php
/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pivotal\TradeIn\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Pivotal\TradeIn\Api\Data\TradeInInterface;
use Pivotal\TradeIn\Api\Data\TradeInInterfaceFactory;
use Pivotal\TradeIn\Api\Data\TradeInSearchResultsInterfaceFactory;
use Pivotal\TradeIn\Api\TradeInRepositoryInterface;
use Pivotal\TradeIn\Model\ResourceModel\TradeIn as ResourceTradeIn;
use Pivotal\TradeIn\Model\ResourceModel\TradeIn\CollectionFactory as TradeInCollectionFactory;

class TradeInRepository implements TradeInRepositoryInterface
{
    /**
     * @var ResourceTradeIn
     */
    protected $resource;

    /**
     * @var TradeInCollectionFactory
     */
    protected $tradeInCollectionFactory;

    /**
     * @var TradeIn
     */
    protected $searchResultsFactory;

    /**
     * @var TradeInInterfaceFactory
     */
    protected $tradeInFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param ResourceTradeIn $resource
     * @param TradeInInterfaceFactory $tradeInFactory
     * @param TradeInCollectionFactory $tradeInCollectionFactory
     * @param TradeInSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceTradeIn $resource,
        TradeInInterfaceFactory $tradeInFactory,
        TradeInCollectionFactory $tradeInCollectionFactory,
        TradeInSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->tradeInFactory = $tradeInFactory;
        $this->tradeInCollectionFactory = $tradeInCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(TradeInInterface $tradeIn)
    {
        try {
            $this->resource->save($tradeIn);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the tradeIn: %1',
                $exception->getMessage()
            ));
        }
        return $tradeIn;
    }

    /**
     * @inheritDoc
     */
    public function get($tradeInId)
    {
        $tradeIn = $this->tradeInFactory->create();
        $this->resource->load($tradeIn, $tradeInId);
        if (!$tradeIn->getId()) {
            throw new NoSuchEntityException(__('trade_in with id "%1" does not exist.', $tradeInId));
        }
        return $tradeIn;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->tradeInCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(TradeInInterface $tradeIn)
    {
        try {
            $tradeInModel = $this->tradeInFactory->create();
            $this->resource->load($tradeInModel, $tradeIn->getTradeInId());
            $this->resource->delete($tradeInModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the trade_in: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($tradeInId)
    {
        return $this->delete($this->get($tradeInId));
    }
}
