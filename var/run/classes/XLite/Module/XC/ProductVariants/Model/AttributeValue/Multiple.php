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

namespace XLite\Module\XC\ProductVariants\Model\AttributeValue;

/**
 * Abstract multiple attribute value
 *
 * @MappedSuperClass
 */
abstract class Multiple extends \XLite\Model\AttributeValue\MultipleAbstract implements \XLite\Base\IDecorator
{
    /**
     * Check is apply or nor
     *
     * @return boolean
     */
    protected function isApply()
    {
        $result = parent::isApply();

        if ($result && $this->getProduct()->mustHaveVariants()) {
            foreach ($this->getProduct()->getVariantsAttributes() as $attr) {
                if ($attr->getId() == $this->getAttribute()->getId()) {
                    // Current attribute is used in variants, return false
                    $result = false;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get current product variant
     *
     * @return \XLite\Module\XC\ProductVariant\Model\ProductVariant
     */
    protected function getVariant()
    {
        $variant = null;

        if ($this->getProduct()->mustHaveVariants()) {
            $variant = $this->getProduct()->getVariant($this->getProduct()->getAttrValues() ?: null);
        }

        return $variant;
    }

    /**
     * Get price modifier base value
     *
     * @return float
     */
    protected function getModifierBasePrice()
    {
        return $this->getVariant() ? $this->getVariant()->getClearPrice() : parent::getModifierBasePrice();
    }

    /**
     * Get weight modifier base value
     *
     * @return float
     */
    protected function getModifierBaseWeight()
    {
        return $this->getVariant() ? $this->getVariant()->getClearWeight() : parent::getModifierBaseWeight();
    }
}
