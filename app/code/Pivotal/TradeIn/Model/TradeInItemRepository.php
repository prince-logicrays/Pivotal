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
use Pivotal\TradeIn\Api\Data\TradeInItemInterface;
use Pivotal\TradeIn\Api\Data\TradeInItemInterfaceFactory;
use Pivotal\TradeIn\Api\Data\TradeInItemSearchResultsInterfaceFactory;
use Pivotal\TradeIn\Api\TradeInItemRepositoryInterface;
use Pivotal\TradeIn\Model\ResourceModel\TradeInItem as ResourceTradeInItem;
use Pivotal\TradeIn\Model\ResourceModel\TradeInItem\CollectionFactory as TradeInItemCollectionFactory;

class TradeInItemRepository implements TradeInItemRepositoryInterface
{
    /**
     * @var TradeInItemCollectionFactory
     */
    protected $tradeInItemCollectionFactory;

    /**
     * @var TradeInItemInterfaceFactory
     */
    protected $tradeInItemFactory;

    /**
     * @var TradeInItem
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceTradeInItem
     */
    protected $resource;

    /**
     * @param ResourceTradeInItem $resource
     * @param TradeInItemInterfaceFactory $tradeInItemFactory
     * @param TradeInItemCollectionFactory $tradeInItemCollectionFactory
     * @param TradeInItemSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceTradeInItem $resource,
        TradeInItemInterfaceFactory $tradeInItemFactory,
        TradeInItemCollectionFactory $tradeInItemCollectionFactory,
        TradeInItemSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->tradeInItemFactory = $tradeInItemFactory;
        $this->tradeInItemCollectionFactory = $tradeInItemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(TradeInItemInterface $tradeInItem)
    {
        try {
            $this->resource->save($tradeInItem);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the tradeInItem: %1',
                $exception->getMessage()
            ));
        }
        return $tradeInItem;
    }

    /**
     * @inheritDoc
     */
    public function get($tradeInItemId)
    {
        $tradeInItem = $this->tradeInItemFactory->create();
        $this->resource->load($tradeInItem, $tradeInItemId);
        if (!$tradeInItem->getId()) {
            throw new NoSuchEntityException(__('trade_in_item with id "%1" does not exist.', $tradeInItemId));
        }
        return $tradeInItem;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->tradeInItemCollectionFactory->create();
        
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
    public function delete(TradeInItemInterface $tradeInItem)
    {
        try {
            $tradeInItemModel = $this->tradeInItemFactory->create();
            $this->resource->load($tradeInItemModel, $tradeInItem->getTradeInItemId());
            $this->resource->delete($tradeInItemModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the trade_in_item: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($tradeInItemId)
    {
        return $this->delete($this->get($tradeInItemId));
    }
}
