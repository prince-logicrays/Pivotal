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
use Pivotal\TradeIn\Api\Data\TradeInAddressInterface;
use Pivotal\TradeIn\Api\Data\TradeInAddressInterfaceFactory;
use Pivotal\TradeIn\Api\Data\TradeInAddressSearchResultsInterfaceFactory;
use Pivotal\TradeIn\Api\TradeInAddressRepositoryInterface;
use Pivotal\TradeIn\Model\ResourceModel\TradeInAddress as ResourceTradeInAddress;
use Pivotal\TradeIn\Model\ResourceModel\TradeInAddress\CollectionFactory as TradeInAddressCollectionFactory;

class TradeInAddressRepository implements TradeInAddressRepositoryInterface
{
    /**
     * @var TradeInAddress
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceTradeInAddress
     */
    protected $resource;

    /**
     * @var TradeInAddressCollectionFactory
     */
    protected $tradeInAddressCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var TradeInAddressInterfaceFactory
     */
    protected $tradeInAddressFactory;

    /**
     * @param ResourceTradeInAddress $resource
     * @param TradeInAddressInterfaceFactory $tradeInAddressFactory
     * @param TradeInAddressCollectionFactory $tradeInAddressCollectionFactory
     * @param TradeInAddressSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceTradeInAddress $resource,
        TradeInAddressInterfaceFactory $tradeInAddressFactory,
        TradeInAddressCollectionFactory $tradeInAddressCollectionFactory,
        TradeInAddressSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->tradeInAddressFactory = $tradeInAddressFactory;
        $this->tradeInAddressCollectionFactory = $tradeInAddressCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(TradeInAddressInterface $tradeInAddress)
    {
        try {
            $this->resource->save($tradeInAddress);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the tradeInAddress: %1',
                $exception->getMessage()
            ));
        }
        return $tradeInAddress;
    }

    /**
     * @inheritDoc
     */
    public function get($tradeInAddressId)
    {
        $tradeInAddress = $this->tradeInAddressFactory->create();
        $this->resource->load($tradeInAddress, $tradeInAddressId);
        if (!$tradeInAddress->getId()) {
            throw new NoSuchEntityException(__('trade_in_address with id "%1" does not exist.', $tradeInAddressId));
        }
        return $tradeInAddress;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->tradeInAddressCollectionFactory->create();
        
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
    public function delete(TradeInAddressInterface $tradeInAddress)
    {
        try {
            $tradeInAddressModel = $this->tradeInAddressFactory->create();
            $this->resource->load($tradeInAddressModel, $tradeInAddress->getTradeInAddressId());
            $this->resource->delete($tradeInAddressModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the trade_in_address: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($tradeInAddressId)
    {
        return $this->delete($this->get($tradeInAddressId));
    }
}
