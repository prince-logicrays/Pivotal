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
 * @category    Logicrays  Team
 * @package     Logicrays_EmailFilter
 * @copyright   Copyright (c) Logicrays (https://www.logicrays.com/)
 * @license     https://www.logicrays.com/
 */

namespace Logicrays\EmailFilter\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class SendContactConfirmationEmail is used of send email
 */

class SendContactConfirmationEmail implements ObserverInterface
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
        $this->emailfilter = $filter;
    }

    /**
     * This function is used for validate input data as per admin side settings
     *
     * @param Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if ($this->helper->isEnabled() && $this->helper->getContactRestriction()) {
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
                        $redirectionUrl = $this->url->getUrl('*/*/index', ['_secure' => true]);
                        $this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
                        return $this->setRefererUrl($redirectionUrl);
                    }
                }
            }
        } catch (Exeption $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
    }
}
