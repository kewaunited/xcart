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

namespace XLite\Module\XC\ProductVariants\View\Product;

/**
 * Quantity box
 */
abstract class QuantityBox extends \XLite\View\Product\QuantityBoxAbstract implements \XLite\Base\IDecorator
{
    /**
     * CSS class
     *
     * @return string
     */
    protected function getClass()
    {
        $maxValue = $this->getParam(self::PARAM_MAX_VALUE);
        $nonDefaultAmount = isset($maxValue)
                            || (
                                $this->getOrderItem()
                                && $this->getOrderItem()->getVariant()
                                && !$this->getOrderItem()->getVariant()->getDefaultAmount()
                            );
        $max = $nonDefaultAmount || $this->getProduct()->getInventory()->getEnabled() ? ',max[' . $this->getMaxQuantity() . ']' : '';

        return trim(
            'quantity'
            . ' wheel-ctrl'
            . ($this->isCartPage() ? ' watcher' : '')
            . ' ' . $this->getParam(self::PARAM_STYLE)
            . ' validate[required,custom[integer],min[' . $this->getMinQuantity() . ']' . $max . ']'
        );
    }

    /**
     * Return maximum allowed quantity
     *
     * @return integer
     */
    protected function getMaxQuantity()
    {
        return $this->getOrderItem() && $this->getOrderItem()->getVariant() && !$this->getOrderItem()->getVariant()->getDefaultAmount()
            ? $this->getOrderItem()->getVariant()->getAvailableAmount() + $this->getOrderItem()->getAmount()
            : parent::getMaxQuantity();
    }
}
