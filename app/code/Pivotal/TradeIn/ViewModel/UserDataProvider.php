<?php
namespace Pivotal\TradeIn\ViewModel;

use Pivotal\TradeIn\Helper\Data;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class UserDataProvider implements ArgumentInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * UserDataProvider constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Get user firstname
     *
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->helper->getPostValue('firstname') ?: $this->helper->getUserFirstName();
    }

    /**
     * Get user lastname
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->helper->getPostValue('lastname') ?: $this->helper->getUserLastName();
    }
    
    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->helper->getPostValue('email') ?: $this->helper->getUserEmail();
    }

    /**
     * Get user telephone
     *
     * @return string
     */
    public function getUserTelephone()
    {
        return $this->helper->getPostValue('phonenumber');
    }

    /**
     * Get user comment
     *
     * @return string
     */
    public function getUserComment()
    {
        return $this->helper->getPostValue('comment');
    }
}
