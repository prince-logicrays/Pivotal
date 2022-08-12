<?php
namespace Pivotal\TradeIn\Controller;

use Pivotal\TradeIn\Model\ConfigInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NotFoundException;

abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Enabled config path
     */
    public const XML_PATH_ENABLED = ConfigInterface::XML_PATH_ENABLED;

    /**
     * @var ConfigInterface
     */
    private $tradeInFormsConfig;

    /**
     * @param Context $context
     * @param ConfigInterface $tradeInFormsConfig
     */
    public function __construct(
        Context $context,
        ConfigInterface $tradeInFormsConfig
    ) {
        parent::__construct($context);
        $this->tradeInFormsConfig = $tradeInFormsConfig;
    }

    /**
     * Dispatch request
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->tradeInFormsConfig->isEnabled()) {
            throw new NotFoundException(__('Page not found.'));
        }
        return parent::dispatch($request);
    }
}
