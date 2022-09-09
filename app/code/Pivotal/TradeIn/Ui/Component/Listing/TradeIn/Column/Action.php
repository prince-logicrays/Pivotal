<?php

namespace Pivotal\TradeIn\Ui\Component\Listing\TradeIn\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    /** Url path */
    public const VIEW_PAGE_URL = 'tradein/tradein/view';

    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * @var string
     */
    private $_viewUrl;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $viewUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $viewUrl = self::VIEW_PAGE_URL
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_viewUrl = $viewUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['trade_in_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_viewUrl,
                            ['trade_in_id' => $item['trade_in_id']]
                        ),
                        'label' => __('View'),
                    ];
                }
            }
        }
        return $dataSource;
    }
}
