<?php
/**
 * Logicrays
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the logicrays.com license that is
 * available through the world-wide-web at this URL:
 * https://www.logicrays.com/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Logicrays Team
 * @package     Logicrays_EmailFilter
 * @copyright   Copyright (c) Logicrays (https://www.logicrays.com/)
 * @license     https://www.logicrays.com/
 */

namespace Logicrays\EmailFilter\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class CreateAccount called to send email dureing account creation time
 */

class CreateAccount implements ObserverInterface
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Filter
     */
    protected $emailfilter;

/**
 * CreateAccount constructor
 *
 * @param \Magento\Framework\App\RequestInterface $request
 * @param \Magento\Framework\Message\ManagerInterface $messageManager
 * @param \Magento\Framework\App\ResponseFactory $responseFactory
 * @param \Magento\Framework\UrlInterface $url
 * @param \Logicrays\EmailFilter\Helper\Data $helper
 * @param \Magento\Email\Model\Template\Filter $filter
 * @param ResultFactory $resultFactory
 */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Logicrays\EmailFilter\Helper\Data $helper,
        \Magento\Email\Model\Template\Filter $filter,
        ResultFactory $resultFactory
    ) {
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->helper = $helper;
        $this->_emailfilter = $filter;
    }
    
    /**
     * Will check admin configurations and based on it will send email
     *
     * @param Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if ($this->helper->isEnabled() && $this->helper->getRegistrationRestriction()) {
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $postData = $observer->getRequest()->getPost();

                $emailExpression = preg_split('/\r\n|[\r\n]/', $this->helper->getEmailrestricton());
                $isValidEmail = true;
                foreach ($emailExpression as $expression) {
                    preg_match('/'.$expression.'/', $postData['email'], $matches);
                    if (!empty($matches)) {
                        $isValidEmail = false;
                        $this->messageManager->addError(__("Sorry, your e-mail address is not available at 
                            this store."));
                        $redirectionUrl = $this->url->getUrl('*/*/create', ['_secure' => true]);
                        $this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
                        return $this->setRefererUrl($redirectionUrl);
                        break;
                    }
                }
            }
        } catch (Exeption $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
    }
}
