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


namespace XLite\Module\XC\FreeShipping\Logic\Order\Modifier;

/**
 * Decorate shipping modifier
 */
class Shipping extends \XLite\Logic\Order\Modifier\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Get shipped items
     *
     * @return array
     */
    public function getItems()
    {
        $items = parent::getItems();
        $result = array();

        foreach ($items as $item) {
            if (!$this->isIgnoreShippingCalculation($item)) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Get shipping rates
     *
     * @return array(\XLite\Model\Shipping\Rate)
     */
    public function getRates()
    {
        $rates = parent::getRates();

        $unsetFree = true;

        // Get total fixed fees value
        $fixedFee = $this->getItemsFreightFixedFee();

        // Get count of items
        $itemsCount = count($this->getItems());

        if (0 == $itemsCount) {

            // There are no items

            if (0 < $fixedFee) {
                // There are items with fixed fee, remove all methods except 'Freight fixed fee'
                foreach ($rates as $k => $rate) {
                    if (!$this->isFixedFeeMethod($rate->getMethod())) {
                        unset($rates[$k]);
                    }
                }

            } else {
                // Are all items marked as Free shipping?
                $unsetFree = false;
                foreach ($rates as $rate) {
                    $rate->setBaseRate(0);
                    $rate->setMarkupRate(0);
                    if (!$rate->getMethod()->getFree()) {
                        // Non free shipping item found
                        $unsetFree = true;
                    }
                }
            }
        }

        // Correct shipping rates list
        foreach ($rates as $k => $rate) {

            $doUnset = false;

            if ($unsetFree && $rate->getMethod()->getFree()) {
                // Unset 'Free shipping' method
                $doUnset = true;

            } elseif (0 < $fixedFee) {

                if (0 < $itemsCount && $this->isFixedFeeMethod($rate->getMethod())) {
                    // Unset 'Freight fixed fee' method if there are other methods
                    $doUnset = true;

                } else {
                    // Add fixed fee value to the base rate value
                    $rates[$k]->setBaseRate($rate->getBaseRate() + $fixedFee);
                }

            } elseif ($this->isFixedFeeMethod($rate->getMethod())) {
                $doUnset = true;
            }

            if ($doUnset) {
                unset($rates[$k]);
            }
        }

        return $rates;
    }

    /**
     * Return true if order item must be excluded from shipping rates calculations
     *
     * @param \XLite\Model\OrderItem $item Order item
     *
     * @return boolean
     */
    protected function isIgnoreShippingCalculation($item)
    {
        return $item->getObject()
            && (
                $item->getObject()->getFreeShip()
                || (
                    $this->isIgnoreProductsWithFixedFee()
                    && 0 < $item->getObject()->getFreightFixedFee()
                )
            );
    }

    /**
     * Get sum of freight fixed fee of all order items
     *
     * @return float
     */
    protected function getItemsFreightFixedFee()
    {
        $result = 0;

        $items = parent::getItems();
        foreach ($items as $item) {
            if (
                $item->getObject()
                && !$item->getObject()->getFreeShip()
                && 0 < $item->getObject()->getFreightFixedFee()
            ) {
                $result += $item->getObject()->getFreightFixedFee() * $item->getAmount();
            }
        }

        return $result;
    }

    /**
     * Return true if shipping method is 'Freight fixed fee'
     *
     * @param \XLite\Model\Shipping\Method $method Shipping method
     *
     * @return boolean
     */
    protected function isFixedFeeMethod($method)
    {
        return \XLite\Model\Shipping\Method::METHOD_TYPE_FIXED_FEE == $method->getCode()
            && 'offline' == $method->getProcessor();
    }

    /**
     * Return true if products with defined shipping freight should be ignored in shipping rates calculations
     *
     * @return boolean
     */
    protected function isIgnoreProductsWithFixedFee()
    {
        $mode = \XLite\Core\Config::getInstance()->XC->FreeShipping->freight_shipping_calc_mode;

        return \XLite\Module\XC\FreeShipping\View\FormField\FreightMode::FREIGHT_ONLY == $mode;
    }

    /**
     * Returns true if any of order items are shipped
     *
     * @return boolean
     */
    protected function isShippable()
    {
        $result = parent::isShippable();

        foreach (parent::getItems() as $item) {
            if ($item->isShippable()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
