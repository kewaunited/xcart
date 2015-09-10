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

namespace XLite\View;

/**
 * Pick address from address book of order
 */
class SelectAddressOrder extends \XLite\View\SelectAddress
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'order';

        return $result;
    }

    /**
     * Get CSS files 
     * 
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'select_address/style.css';

        return $list;
    }

    /**
     * Get addresses list
     *
     * @return array
     */
    public function getAddresses()
    {
        return $this->getOrder()->getAddresses();
    }

    /**
     * Get address fields
     *
     * @return array
     */
    protected function getAddressFields()
    {
        $result = array();

        foreach (\XLite\Core\Database::getRepo('XLite\Model\AddressField')->findAllEnabled() as $field) {
            $result[$field->getServiceName()] = array(
                \XLite\View\Model\Address\Address::SCHEMA_CLASS    => $field->getSchemaClass(),
                \XLite\View\Model\Address\Address::SCHEMA_LABEL    => $field->getName(),
                \XLite\View\Model\Address\Address::SCHEMA_REQUIRED => $field->getRequired(),
                \XLite\View\Model\Address\Address::SCHEMA_MODEL_ATTRIBUTES => array(
                    \XLite\View\FormField\Input\Base\String::PARAM_MAX_LENGTH => 'length',
                ),
                \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-' . $field->getServiceName(),
            );
        }

        return $result;
    }

    /**
     * Get field value
     *
     * @param string               $fieldName    Field name
     * @param \XLite\Model\Address $address      Field name
     *
     * @return string
     */
    protected function getFieldValue($fieldName, \XLite\Model\Address $address)
    {
        $result = '';

        if (isset($address)) {

            $methodName = 'get' . \XLite\Core\Converter::getInstance()->convertToCamelCase($fieldName);

            // $methodName assembled from 'get' + camelized $fieldName
            $result = $address->$methodName();

            if ($result) {

                switch ($fieldName) {
                    case 'state_id':
                        $result = $address->getCountry()->hasStates()
                            ? $address->getState()->getState()
                            : null;
                        break;

                    case 'custom_state':
                        $result = $address->getCountry()->hasStates()
                            ? null
                            : $result;
                        break;

                    case 'country_code':
                        $result = $address->getCountry()->getCountry();
                        break;

                    default:

                }
            }
        }

        return $result;
    }

    /**
     * Check - specified address is selected or not
     *
     * @param \XLite\Model\Address $address Address
     *
     * @return boolean
     */
    public function isSelectedAddress(\XLite\Model\Address $address)
    {
        $shipping = $this->getOrder()->getProfile()->getShippingAddress();
        $billing = $this->getOrder()->getProfile()->getBillingAddress();

        return ($shipping && $shipping->getAddressId() == $address->getAddressId())
            || ($billing && $billing->getAddressId() == $address->getAddressId());
    }

    /**
     * Check - address is shipping address or not
     *
     * @param \XLite\Model\Address $address Address
     *
     * @return boolean
     */
    protected function isShipping(\XLite\Model\Address $address)
    {
        return $this->getOrder()->getProfile()->getShippingAddress()
            && $address->getAddressId() == $this->getOrder()->getProfile()->getShippingAddress()->getAddressId();
    }

    /**
     * Check - address is billing address or not
     *
     * @param \XLite\Model\Address $address Address
     *
     * @return boolean
     */
    protected function isBilling(\XLite\Model\Address $address)
    {
        return $this->getOrder()->getProfile()->getBillingAddress()
            && $address->getAddressId() == $this->getOrder()->getProfile()->getBillingAddress()->getAddressId();
    }

    /**
     * Get address container attributes 
     * 
     * @return array
     */
    protected function getAddressContainerAttributes()
    {
        return array(
            'class' => array(
                'select-address',
                'clearfix',
                ('s' == \XLite\Core\Request::getInstance()->atype ? 'shipping' : 'billing'),
            ),
        );
    }
}
