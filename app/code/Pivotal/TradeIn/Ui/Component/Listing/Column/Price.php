<?php

declare(strict_types=1);

namespace Pivotal\TradeIn\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Directory\Model\Currency;

class Price extends Column
{
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceFormatter;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param PriceCurrencyInterface $priceFormatter
     * @param array $components
     * @param array $data
     * @param Currency $currency
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        PriceCurrencyInterface $priceFormatter,
        array $components = [],
        array $data = [],
        Currency $currency = null
    ) {
        $this->priceFormatter = $priceFormatter;
        $this->currency = $currency ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->create(Currency::class);
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $currencyCode = isset($item['tradein_currency_code']) ? $item['tradein_currency_code'] : null;
                $purchaseCurrency = $this->currency->load($currencyCode);
                $item[$this->getData('name')] = $purchaseCurrency
                    ->format($item[$this->getData('name')], [], false);
            }
        }

        return $dataSource;
    }
}
