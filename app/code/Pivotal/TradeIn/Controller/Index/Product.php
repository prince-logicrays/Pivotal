<?php
namespace Pivotal\TradeIn\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Action\Action;

class Product extends Action implements HttpPostActionInterface
{
    /**
     * CollectionFactory
     *
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * JsonFactory variable
     *
     * @var JsonFactory
     */
    private $jsonResultFactory;

    /**
     * Product function
     *
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param JsonFactory $jsonResultFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        JsonFactory $jsonResultFactory
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * Product function
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $search_text = $this->getRequest()->getPost('search_text');
        $condition_id = $this->getRequest()->getPost('condition_id');
        $condition = $this->getRequest()->getPost('condition');
        $search_text_lower = strtolower($search_text);
        $search_text = trim($search_text);
        $collection = $this->_productCollectionFactory->create();
        $collection = $collection->addAttributeToSelect('*')
                    ->addAttributeToFilter(
                        'status',
                        \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED
                    )
                    ->addAttributeToFilter('name', [
                        ['like' => '% '.$search_text.' %'], //spaces on each side
                        ['like' => '% '.$search_text], //space before and ends with $search_text
                        ['like' => $search_text.' %'] // starts with search_text and space after
                    ]);
        
        $products = [];
        foreach ($collection as $product) {
            $name = strtolower($product->getName());
            // if (strpos($name, $search_text_lower) !== false) {
                    $products[] = [
                       'entity_id' => $product->getId(),
                       'name' => $product->getName(),
                       'condition_id' => $condition_id,
                       'condition' => trim($condition)
                    ];
            // }
        }
        $productCount = null;
        $productCount = $collection->count();
        
        $data = ['success' => true, 'products' => $products, 'productCount' => $productCount];
        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        return $result;
    }
}
