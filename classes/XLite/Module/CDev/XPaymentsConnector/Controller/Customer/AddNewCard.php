<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
 namespace XLite\Module\CDev\XPaymentsConnector\Controller\Customer;

/**
 * Saved credit cards
 *
 */
class AddNewCard extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Placeholde for comma in address
     */
    const COMMA = '__COMMA__';

    /**
     * Error (if any)
     */
    protected $error = '';

    /**
     * Check - controller must work in secure zone or not
     *
     * @return boolean
     */
    public function isSecure()
    {
        return \XLite\Core\Config::getInstance()->Security->customer_security;
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Add new credit card');
    }

    /**
     * Check whether the title is to be displayed in the content area
     *
     * @return boolean
     */
    public function isTitleVisible()
    {
        return true;
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && \XLite\Module\CDev\XPaymentsConnector\Core\ZeroAuth::getInstance()->getPaymentMethod()
            && (
                \XLite\Core\Auth::getInstance()->isLogged()
                || 'check_cart' == \XLite\Core\Request::getInstance()->action
                || 'callback' == \XLite\Core\Request::getInstance()->action
            );
    }

    /**
     * Common method to determine current location
     *
     * @return string
     */
    protected function getLocation()
    {
        return static::t('Add new credit card');
    }

    /**
     * Add part to the location nodes list
     *
     * @return void
     */
    protected function addBaseLocation()
    {
        parent::addBaseLocation();

        $this->addLocationNode('My account');
        $this->addLocationNode('Saved credit cards');
    }

    /**
     * Payment amount for zero-auth (card-setup)
     *
     * @return bool
     */
    public function getAmount()
    {
        return \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector->xpc_zero_auth_amount;
    }

    /**
     * Payment description for zero-auth (card-setup)
     *
     * @return bool
     */
    public function getDescription()
    {
        return \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector->xpc_zero_auth_description;
    }

    /**
     * Get iframe URL 
     *
     * @return string 
     */
    public function getIframeUrl()
    {
        static $url = null;

        if (!$url && $this->getAddressList()) {

            try {
                
                $url = \XLite\Module\CDev\XPaymentsConnector\Core\ZeroAuth::getInstance()->getIframeUrl(
                    $this->getProfile(),
                    \XLite::CART_SELF
                );

            } catch (\Exception $e) {

                $this->error = $e->getMessage();
            }
        }

        return $url;
    }

    /**
     * Get error
     *
     * @return string 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get profile ID
     *
     * @return int
     */
    public function getProfileId()
    {
        return $this->getProfile()->getProfileId();
    }

    /**
     * Get address item as string
     *
     * @param \XLite\Model\Address $address Address
     *
     * @return string
     */
    public function getAddressItem($address)
    {
        static $addressFields = array(
            'firstname', 'lastname', self::COMMA,
            'zipcode', 'street', 'city', self::COMMA,
            'state', self::COMMA,
            'country',
        );

        $result = '';

        foreach ($addressFields as $field) {

            if (self::COMMA == $field) {
                $result = $result . ',';
                continue;
            }

            $method = 'get' . $field;

                $item = $address->$method();

                if (method_exists($item, $method)) {
                    $item = $item->$method();
                }

                $result = $result . ' ' . $item;
        }

        return trim($result);
    }

    /**
     * Get list of addresses
     *
     * @return string
     */
    public function getAddressList()
    {
        static $list = array();

        if (empty($list)) {
            $addresses = $this->getProfile()->getAddresses()->toArray();

            foreach ($addresses as $address) {
                $list[$address->getAddressId()] = $this->getAddressItem($address);
            }
        }

        return $list;
    }

    /**
     * Get address ID
     *
     * return int
     */
    public function getAddressId()
    {
        if ($this->getProfile()->getBillingAddress()) {
            $addressId = $this->getProfile()->getBillingAddress()->getAddressId();
        } else {
            $list = $this->getAddressList();
            $addressId = key($list);
        }

        return $addressId;
    }

    /**
     * Update address
     *
     * return void 
     */
    protected function doActionUpdateAddress()
    {
        $addresses = $this->getProfile()->getAddresses();

        foreach ($addresses as $address) {
            if (\XLite\Core\Request::getInstance()->address_id == $address->getAddressId()) {
                $address->setIsBilling(true);
            } else {
                $address->setIsBilling(false);
            }
        }

        \XLite\Core\Database::getEM()->flush();
    }
    
    /**
     * Customer return action 
     *
     * @return void
     */
    protected function doActionReturn()
    {
        \XLite\Module\CDev\XPaymentsConnector\Core\ZeroAuth::getInstance()->doActionReturn();
    }

    /**
     * Callback from X-Payments 
     *
     * @return void
     */
    protected function doActionCallback()
    {
        \XLite\Module\CDev\XPaymentsConnector\Core\ZeroAuth::getInstance()->doActionCallback();
    }

    /**
     * Check cart callback 
     *
     * @return void
     */
    protected function doActionCheckCart()
    {
        \XLite\Module\CDev\XPaymentsConnector\Core\ZeroAuth::getInstance()->doActionCheckCart();
    }

}
