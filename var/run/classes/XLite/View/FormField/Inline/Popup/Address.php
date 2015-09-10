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

namespace XLite\View\FormField\Inline\Popup;

/**
 * Address
 */
abstract class Address extends \XLite\View\FormField\Inline\Popup\APopup
{

    /**
     * Get JS files 
     * 
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        if (!$this->getViewOnly()) {
            $list[] = 'form_field/select_country.js';
            $list[] = 'form_field/inline/popup/address/controller.js';
        }

        return $list;
    }

    /**
     * Define form field
     *
     * @return string
     */
    protected function defineFieldClass()
    {
        return 'XLite\View\FormField\Input\Hidden';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' inline-address';
    }

    /**
     * Define fields
     *
     * @return array
     */
    protected function defineFields()
    {
        $fields = array();

        foreach (\XLite\Core\Database::getRepo('XLite\Model\AddressField')->findAllEnabled() as $field) {
            $fields[$field->getServiceName()] = array(
                static::FIELD_NAME    => $field->getServiceName(),
                static::FIELD_CLASS   => $this->defineFieldClass(),
            );
        }

        return $fields;        
    }

    /**
     * Get field value from entity
     *
     * @param array $field Field
     *
     * @return mixed
     */
    protected function getFieldEntityValue(array $field)
    {
        $method = 'get' . \Includes\Utils\Converter::convertToCamelCase($field[static::FIELD_NAME]);
        $addressMethod = 'get' . ucfirst($this->getParam(static::PARAM_FIELD_NAME));

        // $method assembled from 'get' + field short name
        return $this->getEntity()->$addressMethod()
            ? $this->getEntity()->$addressMethod()->$method()
            : null;
    }

    /**
     * Get field name parts
     *
     * @param array $field Field
     *
     * @return array
     */
    protected function getNameParts(array $field)
    {
        return array(
            $this->getParam(static::PARAM_FIELD_NAME),
            $field[static::FIELD_NAME],
        );
    }

    /**
     * Get view template
     *
     * @return string
     */
    protected function getViewTemplate()
    {
        return 'form_field/inline/popup/address/view.tpl';
    }

    /**
     * Get field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'form_field/inline/popup/address/field.tpl';
    }

    /**
     * Get popup parameters
     *
     * @return array
     */
    protected function getPopupParameters()
    {
        $list = parent::getPopupParameters();

        $list['type'] = $this->getParam(static::PARAM_FIELD_NAME);

        return $list;
    }

    /**
     * Save field value to entity
     *
     * @param array $field Field
     * @param mixed $value Value
     *
     * @return void
     */
    protected function saveFieldEntityValue(array $field, $value)
    {
        $address = $this->getAddressModel();

        if ($address) {

            // Get property old value
            $getterMethod = 'get' . \XLite\Core\Converter::convertToCamelCase($field['field'][static::FIELD_NAME]);

            if (method_exists($address, $getterMethod)) {
                // Set address property via specific method
                $oldValue = $address->$getterMethod();

            } else {
                // Set address property via common setterProperty() method
                $oldValue = $address->getterProperty($field['field'][static::FIELD_NAME], $value);
            }

            // Set address property
            $setterMethod = $this->getAddressFieldMethodName($field);

            if (method_exists($address, $setterMethod)) {
                // Set address property via specific method
                $address->$setterMethod($value);

            } else {
                // Set address property via common setterProperty() method
                $address->setterProperty($field['field'][static::FIELD_NAME], $value);
            }

            if ($value != $oldValue) {

                // Prepare data to register as an order changes

                $ignoreChange = false;

                $fieldName = $field['field'][static::FIELD_NAME];

                switch ($fieldName) {

                    case 'country_code': {
                        $fieldName = 'Country';
                        $oldCountry = \XLite\Core\Database::getRepo('XLite\Model\Country')->findOneBy(array('code' => $oldValue));
                        $oldValue = $oldCountry ? $oldCountry->getCountry() : $oldValue;
                        $newCountry = \XLite\Core\Database::getRepo('XLite\Model\Country')->findOneBy(array('code' => $value));
                        $value = $newCountry ? $newCountry->getCountry() : $value;
                        break;
                    }

                    case 'state_id': {
                        if ($address->getCountry() && $address->getCountry()->hasStates()) {
                            $fieldName = 'State';
                            $oldState = \XLite\Core\Database::getRepo('XLite\Model\State')->find($oldValue);
                            $oldValue = $oldState ? $oldState->getState() : $oldValue;
                            $newState = \XLite\Core\Database::getRepo('XLite\Model\State')->find($value);
                            $value = $newState ? $newState->getState() : $value;

                        } else {
                            $ignoreChange = true;
                        }
                        break;
                    }

                    case 'custom_state': {
                        if ($address->getCountry() && $address->getCountry()->hasStates()) {
                            $ignoreChange = true;

                        } else {
                            $fieldName = 'State';
                        }
                        break;
                    }
                }

                if (!$ignoreChange) {
                    \XLite\Controller\Admin\Order::setOrderChanges(
                        $this->getParam(static::PARAM_FIELD_NAME) . ':' . $fieldName,
                        $value,
                        $oldValue
                    );
                }
            }
        }
    }

    /**
     * Get address model 
     * 
     * @return \XLite\Model\Address
     */
    protected function getAddressModel()
    {
        // Prepare address getter (getBillingAddress or getShippingAddress)
        $addressMethod = 'get' . \XLite\Core\Converter::convertToCamelCase($this->getParam(static::PARAM_FIELD_NAME));

        return $this->getEntity()->$addressMethod();
    }

    /**
     * Get address field method name 
     * 
     * @param array $field Field
     *  
     * @return string
     */
    protected function getAddressFieldMethodName(array $field)
    {
        return 'set' . \XLite\Core\Converter::convertToCamelCase($field['field'][static::FIELD_NAME]);
    }
}
