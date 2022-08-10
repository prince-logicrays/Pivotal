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

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Controlleractionpredisaptch called sales order place before
 */

class Controlleractionpredisaptch implements ObserverInterface
{
    
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var Http
     */
    protected $http;

    protected $logger;

/**
 * Controlleractionpredisaptch constructor
 *
 * @param \Magento\Framework\App\RequestInterface $request
 * @param \Magento\Framework\Message\ManagerInterface $messageManager
 * @param \Magento\Framework\App\ResponseFactory $responseFactory
 * @param \Magento\Framework\UrlInterface $url
 * @param \Magento\Checkout\Model\Session $checkoutSession
 * @param \Magento\Customer\Model\Session $session
 * @param \Logicrays\EmailFilter\Helper\Data $helper
 * @param \Magento\Framework\App\Response\Http $http
 * @param ResultFactory $resultFactory
 */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $session,
        \Logicrays\EmailFilter\Helper\Data $helper,
        \Magento\Framework\App\Response\Http $http,
        ResultFactory $resultFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
        $this->session = $session;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->http = $http;
        $this->logger = $logger;
    }

    /**
     * This function check admin settings and based on it email send
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->isEnabled() && $this->helper->getCheckoutRestriction()) {
            $order = $observer->getEvent()->getOrder();
            $checkoutSession = $this->checkoutSession;

            // $this->logger->info('iodjfgio');
            // $this->logger->debug('iodjfgio');

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $postData = $order->getShippingAddress()->getEmail();
            $emailExpression = preg_split('/\r\n|[\r\n]/', $this->helper->getEmailrestricton());
            $isValidEmail = true;
            foreach ($emailExpression as $expression) {
                preg_match('/'.$expression.'/', $postData, $matches);

                if (!empty($matches)) {
                    $isValidEmail = false;
                    throw new NoSuchEntityException(__('Sorry, your e-mail address is not available at this store.'));
                }
            }
        }
    }
}
