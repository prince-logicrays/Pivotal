<?php
namespace Pivotal\TradeIn\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Directory\Model\RegionFactory;

class Country extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * @var RegionFactory
     */
    protected $regionColFactory;
    
    /**
     * __construct function
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param RegionFactory $regionColFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        RegionFactory $regionColFactory
    ) {
        $this->regionColFactory = $regionColFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Get regions and countries
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        echo "here";
        exit;
        $result = $this->resultJsonFactory->create();
        $regions=$this->regionColFactory->create()
                ->getCollection()
                ->addFieldToFilter(
                    'country_id',
                    $this->getRequest()->getParam('country')
                );

        $html = '';

        if (count($regions) > 0) {
            $html.='<option selected="selected" value="">Please select a region, state or province.</option>';
            
            foreach ($regions as $state) {
                $html.=    '<option  value="'.$state->getName().'">'.$state->getName().'.</option>';
            }
        }
        return $result->setData(['success' => true,'value'=>$html]);
    }
}
