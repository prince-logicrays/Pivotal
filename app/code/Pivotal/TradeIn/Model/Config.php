<?php

namespace Pivotal\TradeIn\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var SenderResolverInterface
     */
    private $senderResolver;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SenderResolverInterface $senderResolver
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SenderResolverInterface $senderResolver
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->senderResolver = $senderResolver;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
}
