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
 * Invoice item attribute values
 *
 * @ListChild (list="invoice.item.name", weight="50")
 * @ListChild (list="invoice.item.name", weight="20", zone="admin")
 * @ListChild (list="invoice.item.name", weight="50", zone="mail")
 * @ListChild (list="order.items.item.name", weight="20", zone="admin")
 */
class InvoiceAttributeValues extends \XLite\View\AView
{
    /**
     * Widget parameter names
     */
    const PARAM_ITEM = 'item';

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'invoice_attribute_values/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'invoice_attribute_values/body.tpl';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_ITEM => new \XLite\Model\WidgetParam\Object('Order item', null, false, '\\XLite\\\Model\\OrderItem'),
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getParam(self::PARAM_ITEM)->hasAttributeValues();
    }

    /**
     * Get attribute value
     *
     * @param \XLite\Model\OrderItem\AttributeValue
     *
     * @return string|integer
     */
    protected function getAttributeId(\XLite\Model\OrderItem\AttributeValue $attrValue)
    {
        $attribute = $attrValue->getAttributeValue() ? $attrValue->getAttributeValue()->getAttribute() : null;

        if (!$attribute && $attrValue->getAttributeId()) {
            $attribute = \XLite\Core\Database::getRepo('XLite\Model\Attribute')->find($attrValue->getAttributeId());
        }

        return $attribute ? $attribute->getId() : $attrValue->getAttributeValueId();
    }

    /**
     * Get value container attributes 
     * 
     * @param \XLite\Model\OrderItem\AttributeValue $attrValue Attribute value
     *  
     * @return array
     */
    protected function getValueContainerAttributes(\XLite\Model\OrderItem\AttributeValue $attrValue)
    {
        $attributes = array(
            'class' => array('av-' . $this->getAttributeId($attrValue)),
        );

        if ($this->needFade($attrValue)) {
            $attributes['class'][] = 'text';
            $attributes['title'] = $attrValue->getActualValue();
            $attributes['data-toggle'] = 'tooltip';
            $attributes['data-placement'] = 'bottom';

        } elseif ($this->isYesNo($attrValue)) {
            $attributes['class'][] = 'yes-no';
        }

        return $attributes;
    }

    /**
     * Check - need right fade or not
     *
     * @param \XLite\Model\OrderItem\AttributeValue $attrValue Attribute value
     *
     * @return boolean
     */
    protected function needFade(\XLite\Model\OrderItem\AttributeValue $attrValue)
    {
        return $attrValue->getAttributeValue() instanceOf \XLite\Model\AttributeValue\AttributeValueText;
    }

    /**
     * Check - attribute is YanNo type or not
     *
     * @param \XLite\Model\OrderItem\AttributeValue $attrValue Attribute value
     *
     * @return boolean
     */
    protected function isYesNo(\XLite\Model\OrderItem\AttributeValue $attrValue)
    {
        return $attrValue->getAttributeValue() instanceOf \XLite\Model\AttributeValue\AttributeValueCheckbox;
    }

    /**
     * Get plain values 
     * 
     * @return array
     */
    protected function getPlainValues()
    {
        $list = array();

        foreach ($this->getParam(self::PARAM_ITEM)->getAttributeValues() as $av) {
            if (!$this->needFade($av)) {
                $list[] = $av;
            }
        }

        return $list;
    }

    /**
     * Get text values
     *
     * @return array
     */
    protected function getTextValues()
    {
        $list = array();

        foreach ($this->getParam(self::PARAM_ITEM)->getAttributeValues() as $av) {
            if ($this->needFade($av)) {
                $list[] = $av;
            }
        }

        return $list;
    }

    /**
     * Get Yes/No values
     *
     * @return array
     */
    protected function getYesNoValues()
    {
        $list = array();

        foreach ($this->getParam(self::PARAM_ITEM)->getAttributeValues() as $av) {
            if ($this->isYesNo($av)) {
                $list[] = $av;
            }
        }

        return $list;
    }

}
