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

namespace XLite\View\FormField\Inline\Input\Text\Price;

/**
 * Order surcharge widget for AOM
 */
class OrderModifierTotal extends \XLite\View\FormField\Inline\Input\Text\Price\AbsPrice
{
    /**
     * Set widget params
     *
     * @param array $params Handler params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        parent::setWidgetParams($params);

        if ($this->getParam(static::PARAM_ENTITY) && !$this->getParam(static::PARAM_FIELD_NAME)) {
            $this->getWidgetParams(static::PARAM_FIELD_NAME)->setValue(
                $this->getParam(static::PARAM_ENTITY)->getCode()
            );
        }
    }

    /**
     * Get initial field parameters
     *
     * @param array $field Field data
     *
     * @return array
     */
    protected function getFieldParams(array $field)
    {
        return parent::getFieldParams($field) + array('min' => 0, 'mouseWheelCtrl' => false);
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
            'orderModifiers',
            $this->getParam(static::PARAM_FIELD_NAME),
        );
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
        $value = $this->getEntity()->getValue();
        if ($this->getEntity()->getType() == \XLite\Model\Base\Surcharge::TYPE_DISCOUNT && $value < 0) {
            $value = abs($value);
        }

        return $value;
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
        $data = \XLite\Core\Request::getInstance()->getPostData();

        $currency = $this->getEntity()->getOrder()->getCurrency();
        $isPersistent = $this->getEntity()->isPersistent();

        if (
            !empty($data['auto']['surcharges'][$this->getEntity()->getCode()]['value'])
            && $this->getEntity()->getModifier()
        ) {

            if (\XLite\Logic\Order\Modifier\Shipping::MODIFIER_CODE == $this->getEntity()->getCode()) {
                // Reset selected rate to avoid cache
                $this->getEntity()->getModifier()->resetSelectedRate();
            }

            // Calculate surcharge and get new surcharge object or array of surcharge objects
            $surcharges = $this->getEntity()->getModifier()->canApply()
                ? $this->getEntity()->getModifier()->calculate()
                : array();

            if (!is_array($surcharges)) {
                $surcharges = $surcharges ? array($surcharges) : array();
            }

            $value = 0;

            foreach ($surcharges as $surcharge) {

                if (is_object($surcharge)) {

                    if ($surcharge->getCode() == $this->getEntity()->getCode()) {
                        $value += $surcharge->getValue();
                    }

                    // Remove added surcharges if current entity exists in DB to avoid duplicates
                    if ($isPersistent) {
                        \XLite\Core\Database::getEM()->remove($surcharge);
                        $surcharge->getOrder()->getSurcharges()->removeElement($surcharge);
                    }
                }
            }

        } elseif (0 != $value && !$isPersistent) {
            $this->addOrderSurcharge($this->getEntity(), $value);
        }

        if (0 < $value && $this->getEntity()->getType() == \XLite\Model\Base\Surcharge::TYPE_DISCOUNT) {
            $value = $value * -1;
        }

        $oldValue = $currency->roundValue($this->getEntity()->getValue());
        $newValue = $currency->roundValue($value);

        if ($oldValue != $newValue) {
            \XLite\Controller\Admin\Order::setOrderChanges(
                $this->getParam(static::PARAM_FIELD_NAME),
                static::formatPrice(abs($value), $currency, true),
                static::formatPrice(abs($this->getEntity()->getValue()), $currency, true)
            );
        }

        $this->getEntity()->setValue($value);
    }

    /**
     * Add order surcharge
     *
     * @param \XLite\Model\Order\Modifier $modifier Order modifier
     * @param float                       $value    Surcharge value
     *
     * @return void
     */
    protected function addOrderSurcharge($modifier, $value)
    {
        if (0 < $value && $modifier->getType() == \XLite\Model\Base\Surcharge::TYPE_DISCOUNT) {
            $value = $value * -1;
        }

        $modifier->getModifier()->addOrderSurcharge(
            $modifier->getCode(),
            doubleval($value)
        );
    }

    /**
     * Check - field is editable or not
     *
     * @return boolean
     */
    protected function isEditable()
    {
        return !$this->getViewOnly() && ($this->getEditOnly() || $this->getEntity());
    }

}
