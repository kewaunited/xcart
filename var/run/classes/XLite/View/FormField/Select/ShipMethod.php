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

namespace XLite\View\FormField\Select;

/**
 * Shipping method
 */
class ShipMethod extends \XLite\View\FormField\Select\Regular
{
    /**
     * Deleted key code
     */
    const KEY_DELETED = 'deleted';
    const KEY_UNAVAILABLE = 'unavailable';

    /**
     * Shipping options
     *
     * @var array
     */
    protected $shippingOptions;

    /**
     * Order modifier
     *
     * @var \XLite\Model\Order\Modifier
     */
    protected $modifier;

    /**
     * Shipping method
     *
     * @var \XLite\Model\Shipping\Method
     */
    protected $method;

    /**
     * Get current order entity
     *
     * @return \XLite\Model\Order
     */
    protected function getOrderEntity()
    {
        $order = $this->getOrder();

        return \XLite\Controller\Admin\Order::getTemporaryOrder($order->getOrderId(), false) ?: $order;
    }

    /**
     * Get modifier
     *
     * @return \XLite\Model\Order\Modifier
     */
    protected function getModifier()
    {
        if (null === $this->modifier) {
            $this->modifier = $this->getOrderEntity()
                ->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
            $this->modifier->setMode(\XLite\Logic\Order\Modifier\AModifier::MODE_CART);

            $this->method = $this->modifier->getMethod();
        }

        return $this->modifier;
    }

    /**
     * Get selected shipping method
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getMethod()
    {
        if (null === $this->method) {
            $this->getModifier();
        }

        return $this->method;
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return \XLite::getController()->isOrderEditable()
            ? $this->getShippingOptions()
            : array();
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getShippingOptions()
    {
        if (null === $this->shippingOptions) {
            $this->shippingOptions = array(
                0 => static::t('None'),
            );

            if (!$this->getMethod() && $this->getOrderEntity()->getShippingMethodName()) {
                $this->shippingOptions[static::KEY_DELETED]
                    = $this->getOrderEntity()->getShippingMethodName() . ' (' . static::t('deleted') . ')';
            }

            foreach ($this->getModifier()->getRates() as $rate) {
                $this->shippingOptions[$this->getMethodId($rate)] = html_entity_decode(
                    $this->getFormattedShippingName($rate),
                    ENT_COMPAT,
                    'UTF-8'
                );
            }

            if ($this->getMethod()
                && !in_array($this->getMethod()->getMethodId(), array_keys($this->shippingOptions))
            ) {
                $this->shippingOptions[static::KEY_UNAVAILABLE]
                    = $this->getOrderEntity()->getShippingMethodName() . ' (' . static::t('unavailable') . ')';
            }
        }

        return $this->shippingOptions;
    }

    /**
     * Check - build options or not
     *
     * @return boolean
     */
    protected function isBuildOptions()
    {
        return !\XLite\Model\Shipping::isIgnoreLongCalculations();
    }

    /**
     * Get rate method id
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return integer
     */
    protected function getMethodId(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getMethod()->getMethodId();
    }

    /**
     * Get formatted shipping name
     *
     * @param \XLite\Model\Shipping\Rate $rate Rate
     *
     * @return string
     */
    protected function getFormattedShippingName(\XLite\Model\Shipping\Rate $rate)
    {
        return $this->getMethodName($rate);
    }

    /**
     * Get rate method name
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return string
     */
    protected function getMethodName(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getMethod()->getName();
    }

    /**
     * Get option attributes
     *
     * @param mixed $value Value
     * @param mixed $text  Text
     *
     * @return array
     */
    protected function getOptionAttributes($value, $text)
    {
        $attributes = parent::getOptionAttributes($value, $text);
        $attributes['data-value'] = $text;

        return $attributes;
    }

    /**
     * Get common attributes
     *
     * @return array
     */
    protected function getCommonAttributes()
    {
        $attributes = parent::getCommonAttributes();

        $value = $this->getValue();
        if (!$this->getMethod() && $this->getOrderEntity()->getShippingMethodName()) {
            $value = static::KEY_DELETED;
        }

        if ($this->getMethod()
            && !in_array($this->getMethod()->getMethodId(), array_keys($this->shippingOptions))
        ) {
            $value = static::KEY_UNAVAILABLE;
        }

        $attributes['data-value'] = $value;
        $attributes['data-request-options'] = !$this->isBuildOptions();

        return $attributes;
    }
}
