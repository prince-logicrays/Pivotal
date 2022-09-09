<?php

namespace Pivotal\TradeIn\Block\ArrangeShipping;

use Magento\Framework\View\Element\Template;
use Pivotal\TradeInPricing\Model\TradeInPricingFactory;
use Pivotal\TradeIn\Helper\Data;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\ResourceModel\Address\CollectionFactory as AddressCollectionFactory;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Customer\Model\Session as CustomerSession;
use Pivotal\TradeIn\Model\Config\Source\ArrangeFreeShippingMethods;
use Magento\Directory\Block\Data as DirectoryBlock;

class Address extends Template
{
    /**
     * @var TradeInPricingFactory
     */
    protected $tradeinpricingFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Address\CollectionFactory
     */
    private $addressCollectionFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Address\Collection
     */
    private $addressCollection;

    /**
     * @var CountryFactory
     */
    private $countryFactory;

    /**
     * @var ArrangeFreeShippingMethods
     */
    private $arrangeFreeShippingMethods;

    /**
     * @var DirectoryBlock
     */
    private $directoryBlock;

    /**
     * @param Template\Context $context
     * @param TradeInPricingFactory $tradeinpricingFactory
     * @param Data $helper
     * @param CurrentCustomer $currentCustomer
     * @param AddressCollectionFactory $addressCollectionFactory
     * @param CountryFactory $countryFactory
     * @param CustomerSession $customerSession
     * @param ArrangeFreeShippingMethods $arrangeFreeShippingMethods
     * @param DirectoryBlock $directoryBlock
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TradeInPricingFactory $tradeinpricingFactory,
        Data $helper,
        CurrentCustomer $currentCustomer,
        AddressCollectionFactory $addressCollectionFactory,
        CountryFactory $countryFactory,
        CustomerSession $customerSession,
        ArrangeFreeShippingMethods $arrangeFreeShippingMethods,
        DirectoryBlock $directoryBlock,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->tradeinpricingFactory = $tradeinpricingFactory;
        $this->_isScopePrivate = true;
        $this->helper = $helper;
        $this->currentCustomer = $currentCustomer;
        $this->addressCollectionFactory = $addressCollectionFactory;
        $this->countryFactory = $countryFactory;
        $this->_customerSession = $customerSession;
        $this->arrangeFreeShippingMethods = $arrangeFreeShippingMethods;
        $this->directoryBlock = $directoryBlock;
    }

    /**
     * Get book your free shiping content
     *
     * @return string
     */
    public function getBookYourFreeShippingDescription()
    {
        return $this->helper->getBookYourFreeShippingDescription();
    }

    /**
     * Get current customer
     *
     * Return stored customer or get it from session
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @since 102.0.1
     */
    public function getCustomer(): \Magento\Customer\Api\Data\CustomerInterface
    {
        $customer = $this->getData('customer');
        if ($customer === null) {
            $customer = $this->currentCustomer->getCustomer();
            $this->setData('customer', $customer);
        }
        return $customer;
    }

    /**
     * Get current additional customer addresses
     *
     * Return array of address interfaces if customer has additional addresses and false in other cases
     *
     * @return \Magento\Customer\Api\Data\AddressInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws NoSuchEntityException
     * @since 102.0.1
     */
    public function getCustomerAddresses(): array
    {
        $addressesArray = [];
        if ($this->_customerSession->isLoggedIn()) {
            $addresses = $this->getAddressCollection();
            foreach ($addresses as $address) {
                $_address = $address->getDataModel();
                $html = null;
                $temp = [];
                $html .= $_address->getFirstname()?$_address->getFirstname().", ":"";
                $html .= $_address->getLastname()?$_address->getLastname().", ":"";
                $html .= $_address->getStreet()?$this->getStreetAddress($_address).", ":"";
                $html .= $_address->getCity()?$_address->getCity().", ":"";
                $html .= $_address->getRegion()->getRegion()?$_address->getRegion()->getRegion()." ":"";
                $html .= $_address->getPostcode()?$_address->getPostcode().", ":"";
                $html .= $_address->getCountryId()?$this->getCountryByCode($_address->getCountryId())." ":"";
                $temp ['address_id'] = $_address->getId();
                $temp ['address'] = $html;
                $addressesArray[] = $temp;
            }
        }
        return $addressesArray;
    }

    /**
     * Get customer addresses collection.
     *
     * Filters collection by customer id
     *
     * @return \Magento\Customer\Model\ResourceModel\Address\Collection
     * @throws NoSuchEntityException
     */
    private function getAddressCollection(): \Magento\Customer\Model\ResourceModel\Address\Collection
    {
        if (null === $this->addressCollection) {
            if (null === $this->getCustomer()) {
                throw new NoSuchEntityException(__('Customer not logged in'));
            }
            /** @var \Magento\Customer\Model\ResourceModel\Address\Collection $collection */
            $collection = $this->addressCollectionFactory->create();
            $collection->setOrder('entity_id', 'asc');
            $collection->setCustomerFilter([$this->getCustomer()->getId()]);
            $this->addressCollection = $collection;
        }
        return $this->addressCollection;
    }

    /**
     * Get country name by $countryCode
     *
     * Using \Magento\Directory\Model\Country to get country name by $countryCode
     *
     * @param string $countryCode
     * @return string
     * @since 102.0.1
     */
    public function getCountryByCode(string $countryCode): string
    {
        /** @var \Magento\Directory\Model\Country $country */
        $country = $this->countryFactory->create();
        return $country->loadByCode($countryCode)->getName();
    }

    /**
     * Get one string street address from the Address DTO passed in parameters
     *
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     * @return string
     * @since 102.0.1
     */
    public function getStreetAddress(\Magento\Customer\Api\Data\AddressInterface $address): string
    {
        $street = $address->getStreet();
        if (is_array($street)) {
            $street = implode(', ', $street);
        }
        return $street;
    }

    /**
     * Get arrange free shipping methods
     *
     * @return array
     */
    public function getArrangeFreeShippingMethods()
    {
        $freeShippingMethods = $this->arrangeFreeShippingMethods->toOptionArray();
        $methods = $temp = [];
        foreach ($freeShippingMethods as $method) {
            $temp['method_code'] = $method['value'];
            $temp['method_title'] = $method['label']->getText();
            $methods [] = $temp;
        }
        return $methods;
    }

    /**
     * Get countries function
     *
     * @return array
     */
    public function getHomeAddressCountries()
    {
        $defValue = null;
        $name = 'home_address_country_id';
        $id = 'home_address_country';
        $title = 'Country';
        $country = $this->directoryBlock->getCountryHtmlSelect($defValue, $name, $id, $title);
        return $country;
    }

    /**
     * Get countries function
     *
     * @return array
     */
    public function getDifferentToHomeAddressCountries()
    {
        $defValue = null;
        $name = 'different_to_home_address_country_id';
        $id = 'different_to_home_address_country';
        $title = 'Country';
        $country = $this->directoryBlock->getCountryHtmlSelect($defValue, $name, $id, $title);
        return $country;
    }

    /**
     * Get regions function
     *
     * @return mixed
     */
    public function getRegion()
    {
        $region = $this->directoryBlock->getRegionHtmlSelect();
        return $region;
    }

    /**
     * Get country action function
     *
     * @return string
     */
    public function getCountryAction()
    {
        return $this->getUrl('trade_in/index/country', ['_secure' => true]);
    }
}
