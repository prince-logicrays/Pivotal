<?php
namespace Logicrays\ForwardToConfigurable\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
	const FORWORD_TO_CONFIG = 'forwordtoconfig/general/enable';
    const FORWORD_TO_CONFIG_GROUP = 'forwordtoconfig/general/enablegroup';
	
	
    protected $_modelStoreManagerInterface;
	protected $_frameworkRegistry;

    public function __construct(Context $context, 
        StoreManagerInterface $modelStoreManagerInterface, 
        Registry $frameworkRegistry)
    {
        $this->_modelStoreManagerInterface = $modelStoreManagerInterface;
        $this->_frameworkRegistry = $frameworkRegistry;
        
		parent::__construct($context);
    }

	public function isEnabled()
	{
     	$isEnable = $this->scopeConfig->getValue(self::FORWORD_TO_CONFIG, ScopeInterface::SCOPE_STORE);
     	return $isEnable;
	}
    public function isEnabledGroup()
    {
        $isEnable = $this->scopeConfig->getValue(self::FORWORD_TO_CONFIG_GROUP, ScopeInterface::SCOPE_STORE);
        return $isEnable;
    }
		  	  
}