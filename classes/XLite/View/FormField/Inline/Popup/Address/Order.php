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

namespace XLite\View\FormField\Inline\Popup\Address;

/**
 * Order's address
 */
class Order extends \XLite\View\FormField\Inline\Popup\Address
{
    const SAME_AS_BILLING = 'same_as_billing';

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
     * Get popup widget
     *
     * @return string
     */
    protected function getPopupWidget()
    {
        return '\XLite\View\Address\OrderModify';
    }

    /**
     * Get popup target
     *
     * @return string
     */
    protected function getPopupTarget()
    {
        return 'order';
    }

    /**
     * Get popup parameters
     *
     * @return array
     */
    protected function getPopupParameters()
    {
        $list = parent::getPopupParameters();

        $order = $this->getEntity()->getOrder() ?: $this->getOrder();;

        $list['order_id'] = $order->getOrderId();

        return $list;
    }

    /**
     * Define fields
     *
     * @return array
     */
    protected function defineFields()
    {
        $fields = parent::defineFields();

        $fields[$this->getAddressIdFieldName()] = array(
            static::FIELD_NAME  => $this->getAddressIdFieldName(),
            static::FIELD_CLASS => 'XLite\View\FormField\Input\Hidden',
        );

        if ('shippingAddress' == $this->getParam(static::PARAM_FIELD_NAME)) {
            $fields[static::SAME_AS_BILLING] = array(
                static::FIELD_NAME  => static::SAME_AS_BILLING,
                static::FIELD_CLASS => 'XLite\View\FormField\Input\Hidden',
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
        if ($this->getAddressIdFieldName() == $field[static::FIELD_NAME]) {
            $addressMethod = 'get' . ucfirst($this->getParam(static::PARAM_FIELD_NAME));
            $result = $this->getEntity()->$addressMethod()
                ? $this->getEntity()->$addressMethod()->getAddressId()
                : null;

        } elseif (static::SAME_AS_BILLING == $field[static::FIELD_NAME]) {
            $result = $this->isSameAsBilling() ? '1' : '0';

        } else {
            $result = parent::getFieldEntityValue($field);
        }

        return $result;
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
        if ($this->canSaveAddressFields() && $this->isWritableField($field)) {
            parent::saveFieldEntityValue($field, $value);
        }
    }

    /**
     * Check - can save address fields
     * 
     * @return boolean
     */
    protected function canSaveAddressFields()
    {
        $name1 = $this->getParam(static::PARAM_FIELD_NAME);

        $request = \XLite\Core\Request::getInstance();

        $result = true;
        if ($request->$name1 && is_array($request->$name1)) {
            $name2 = $this->getAddressIdFieldName();
            $data = $request->$name1;
            if (!empty($data[$name2])) {
                $result = false;
            }
        }

        if (
            $result
            && 'shippingAddress' == $this->getParam(static::PARAM_FIELD_NAME)
            && !empty($request->shippingAddress[static::SAME_AS_BILLING])
        ) {
            $result = false;
        }

        return $result;
    }

    /**
     * Check - field is writable or not
     * 
     * @param array $field Field
     *  
     * @return boolean
     * @since  ____since____
     */
    protected function isWritableField(array $field)
    {
        return !in_array(
            $field['field'][static::FIELD_NAME],
            array($this->getAddressIdFieldName(), static::SAME_AS_BILLING)
        );
    }

    /**
     * Get address ID field name 
     * 
     * @return string
     */
    protected function getAddressIdFieldName()
    {
        return 'id';
    }

    /**
     * Get view template
     *
     * @return string
     */
    protected function getViewTemplate()
    {
        return 'form_field/inline/popup/address/order/view.tpl';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        $class = parent::getContainerClass();

        $class .= ' inline-order-address';

        if ($this->isSameAsBilling()) {
            $class .= ' same-as-billing';
        }

        return trim($class);
    }

    /**
     * Check - addrss is shipping and equal billing
     * 
     * @return boolean
     */
    protected function isSameAsBilling()
    {
        return 'shippingAddress' == $this->getParam(static::PARAM_FIELD_NAME)
            && $this->getEntity()->isEqualAddress();
    }

}
