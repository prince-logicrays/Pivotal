<?php

namespace Pivotal\TradeIn\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Email extends AbstractHelper
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $transportBuilder;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $storeManager;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $inlineTranslation;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $scopeConfig;

    // public const XML_PATH_EMAIL_RECIPIENT = 'trade_in_form/trade_in/recipient_email';
    public const EMAIL_TEMPLATE = 'trade_in_form/trade_in/email_template';
    public const BCC_EMAIL_TEMPLATE = 'trade_in_form/trade_in/copy_to';

    /**
     * Undocumented function
     *
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $state
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    // public function getReceipentEmail()
    // {
    //     $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    //     return $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope);
    // }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getBccReceipentEmail()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $data = $this->scopeConfig->getValue(self::BCC_EMAIL_TEMPLATE, $storeScope);
        $bccData = explode(",", $data);
        return $bccData;
    }


    

    /**
     * Undocumented function
     *
     * @param [type] $templateVars
     * @param [type] $customerEmail
     * @return void
     */
    public function sendEmailToCustomer($templateVars, $customerEmail)
    {
        // $toEmail = $this->getReceipentEmail();

        try {
                // $templateIdentifier = $this->getTemplateIdentifier();
                $storeId = $this->storeManager->getStore()->getId();
                /* email template */
                $template = $this->scopeConfig->getValue(
                    self::EMAIL_TEMPLATE,
                    ScopeInterface::SCOPE_STORE,
                    $storeId
                );
                // set from email
                $sender = $this->scopeConfig->getValue(
                    'trade_in_form/trade_in/sender',
                    ScopeInterface::SCOPE_STORE,
                    $storeId
                );
                $this->inlineTranslation->suspend();
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $templateOptions = [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId
                ];
                $transport = $this->transportBuilder->setTemplateIdentifier($template, $storeScope)
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars($templateVars)
                    ->setFromByScope($sender)
                    ->addTo($customerEmail)
                    ->addBcc($this->getBccReceipentEmail())
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $templateVars
     * @param [type] $adminEmail
     * @return void
     */
    public function sendEmailToAdmin($templateVars, $adminEmail)
    {
        // $toEmail = $this->getReceipentEmail();

        try {
                // $templateIdentifier = $this->getTemplateIdentifier();
                $storeId = $this->storeManager->getStore()->getId();
                /* email template */
                $template = $this->scopeConfig->getValue(
                    self::EMAIL_TEMPLATE,
                    ScopeInterface::SCOPE_STORE,
                    $storeId
                );
                // set from email
                $sender = $this->scopeConfig->getValue(
                    'trade_in_form/trade_in/sender',
                    ScopeInterface::SCOPE_STORE,
                    $storeId
                );
                $this->inlineTranslation->suspend();
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $templateOptions = [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId
                ];
                $transport = $this->transportBuilder->setTemplateIdentifier($template, $storeScope)
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars($templateVars)
                    ->setFromByScope($sender)
                    ->addTo($adminEmail)
                    ->addBcc($this->getBccReceipentEmail())
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();

        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }
}
