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

namespace XLite\View\Product\AttributeValue\Customer;

/**
 * Abstract attribute value (customer)
 */
abstract class ACustomer extends \XLite\View\Product\AttributeValue\AAttributeValue
{
    /**
     * Widget param names
     */
    const PARAM_ORDER_ITEM = 'orderItem';
    const PARAM_NAME_PREFIX = 'namePrefix';
    const PARAM_NAME_SUFFIX = 'nameSuffix';

    /**
     * Selected attribute value ids
     *
     * @var array
     */
    protected $selectedIds = null;

    /**
     * Return field name
     *
     * @return string
     */
    protected function getName()
    {
        return $this->getParam(static::PARAM_NAME_PREFIX)
            . 'attribute_values'
            . $this->getParam(static::PARAM_NAME_SUFFIX)
            . '['
            . $this->getAttribute()->getId()
            . ']';
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_ORDER_ITEM => new \XLite\Model\WidgetParam\Object(
                'Order item', null, false, 'XLite\Model\OrderItem'
            ),
            static::PARAM_NAME_PREFIX => new \XLite\Model\WidgetParam\String(
                'Field name prefix', '', false
            ),
            static::PARAM_NAME_SUFFIX => new \XLite\Model\WidgetParam\String(
                'Field name suffix', '', false
            ),
        );
    }

    /**
     * Return field attribute
     *
     * @return \XLite\Model\OrderItem
     */
    protected function getOrderItem()
    {
        return $this->getParam(self::PARAM_ORDER_ITEM);
    }

    /**
     * Return selected attribute values ids
     *
     * @return array
     */
    protected function getSelectedIds()
    {
        if (!isset($this->selectedIds)) {
            $this->selectedIds = array();
            if (
                method_exists($this, 'getSelectedAttributeValuesIds')
                || method_exists(\XLite::getController(), 'getSelectedAttributeValuesIds')
            ) {
                $this->selectedIds = $this->getSelectedAttributeValuesIds();

            } else {

                $item = $this->getOrderItem();

                if (
                    $item
                    && $item->getProduct()
                    && $item->hasAttributeValues()
                ) {
                    $this->selectedIds = $item->getAttributeValuesPlain();
                }
            }
        }

        return $this->selectedIds;
    }

    /**
     * Get list of selected attribute values as array(<attr ID> => <attr value or value ID>)
     *
     * @return array
     */
    protected function getSelectedAttributeValuesIds()
    {
        $result = array();

        $attrValues = $this->getProduct()->getAttrValues();

        if (!empty($attrValues) && \XLite\Model\Attribute::TYPE_TEXT != $this->getAttributeType()) {

            $result = array();

            foreach ($attrValues as $k => $attributeValue) {

                $actualAttributeValue = null;

                if ($attributeValue instanceOf \XLite\Model\OrderItem\AttributeValue) {
                    $actualAttributeValue = $attributeValue->getAttributeValue();

                } elseif ($attributeValue instanceOf \XLite\Model\AttributeValue\AAttributeValue) {
                    $actualAttributeValue = $attributeValue;

                } else {
                    $result[$k] = $attributeValue;
                }

                if ($actualAttributeValue) {
                    if ($actualAttributeValue instanceOf \XLite\Model\AttributeValue\AttributeValueText) {
                        $value = $actualAttributeValue->getValue();

                    } else {
                        $value = $actualAttributeValue->getId();
                    }

                    $result[$actualAttributeValue->getAttribute()->getId()] = $value;
                }
            }

            ksort($result);

        } elseif (method_exists(\XLite::getController(), 'getSelectedAttributeValuesIds')) {
            $result = parent::getSelectedAttributeValuesIds();
        }

        return $result;
    }

    /**
     * Get dir
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/attribute_value';
    }
}
