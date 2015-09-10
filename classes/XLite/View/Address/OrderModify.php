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

namespace XLite\View\Address;

/**
 * Order address modification
 */
class OrderModify extends \XLite\View\AView
{

    /**
     * Address (local cache)
     * 
     * @var   \XLite\Model\Address
     */
    protected $address;

    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'address/order/style.css';

        return $list;
    }

    /**
     * Get default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'address/order/modify_address.tpl';
    }

    /**
     * Get model template 
     * 
     * @return string
     */
    protected function getModelTemplate()
    {
        return 'address/order/model.tpl';
    }

    /**
     * Get name 
     * 
     * @return string
     */
    protected function getName()
    {
        $profile = $this->getOrder()->getProfile();
        $address = $profile->getShippingAddress() ?: $profile->getBillingAddress();

        return $address ? $address->getName() : 'n/a';
    }

    /**
     * Get email 
     * 
     * @return string
     */
    protected function getEmail()
    {
        return $this->getOrder()->getProfile()->getLogin();
    }

    /**
     * Get billing address
     *
     * @return \XLite\Model\Address
     */
    protected function getBillingAddress()
    {
        return $this->getOrder()->getProfile()->getBillingAddress() ?: $this->getOrder()->getProfile()->getShippingAddress();
    }

    /**
     * Get shipping address 
     * 
     * @return \XLite\Model\Address
     */
    protected function getShippingAddress()
    {
        return $this->getOrder()->getProfile()->getShippingAddress() ?: $this->getOrder()->getProfile()->getBillingAddress();
    }

    /**
     * Check - billing address is same shipping address
     * 
     * @return boolean
     */
    protected function isSameShipping()
    {
        return $this->getShippingAddress()->getAddressId() == $this->getBillingAddress()->getAddressId();
    }

    /**
     * Get container attributes 
     * 
     * @return array
     */
    protected function getContainerAttributes()
    {
        $attributes = array(
            'class' => array('order-address-dialog'),
        );

        switch (\XLite\Core\Request::getInstance()->type) {
            case 'shippingAddress':
                $attributes['class'][] = 'shipping-section';
                break;

            case 'billingAddress':
                $attributes['class'][] = 'billing-section';
                break;

            default:
        }

        if ($this->isSameShipping()) {
            $attributes['class'][] = 'same-address';
        }

        return $attributes;
    }

    /**
     * Get billing container attributes
     *
     * @return array
     */
    protected function getBillingContainerAttributes()
    {
        $attributes = array(
            'class' => array('address-box', 'billing', 'clearfix'),
        );

        if ('shippingAddress' == \XLite\Core\Request::getInstance()->type) {
            $attributes['class'][] = 'collapsed';
        }

        return $attributes;
    }

    /**
     * Get billing container attributes
     *
     * @return array
     */
    protected function getShippingContainerAttributes()
    {
        $attributes = array(
            'class' => array('address-box', 'shipping', 'clearfix'),
        );

        if ('billingAddress' == \XLite\Core\Request::getInstance()->type) {
            $attributes['class'][] = 'collapsed';
        }

        return $attributes;
    }

    /**
     * Checks whether display 'Address book' button or not
     *
     * @return boolean
     */
    protected function isDisplayAddressButton()
    {
        return 1 < count($this->getOrder()->getAddresses());
    }
}
