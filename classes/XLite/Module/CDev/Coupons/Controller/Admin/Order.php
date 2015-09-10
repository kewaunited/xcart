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

namespace XLite\Module\CDev\Coupons\Controller\Admin;

/**
 * Order page controller
 */
class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    /**
     * Define the actions with no secure token
     *
     * @return array
     */
    public static function defineFreeFormIdActions()
    {
        return array_merge(parent::defineFreeFormIdActions(), array('check_coupon'));
    }

    /**
     * Check coupon 
     * 
     * @return void
     */
    protected function doActionCheckCoupon()
    {
        $code = strval(\XLite\Core\Request::getInstance()->code);
        $coupon = \XLite\Core\Database::getRepo('XLite\Module\CDev\Coupons\Model\Coupon')
            ->findOneByCode($code);

        $codes = $coupon ? $coupon->getErrorCodes($this->getOrder()) : array();

        $error = null;

        $this->valid = false;

        if (!$coupon || $codes) {
            if (
                $coupon
                && in_array(\XLite\Module\CDev\Coupons\Model\Coupon::ERROR_TOTAL, $codes)
            ) {
                $currency = $this->getOrder()->getCurrency();

                if (
                    0 < $coupon->getTotalRangeBegin()
                    && 0 < $coupon->getTotalRangeEnd()
                ) {
                    $error = static::t(
                        'To use the coupon, your order subtotal must be between X and Y',
                        array(
                            'min' => $currency->formatValue($coupon->getTotalRangeBegin()),
                            'max' => $currency->formatValue($coupon->getTotalRangeEnd()),
                        )
                    );

                } elseif (0 < $coupon->getTotalRangeBegin()) {
                    $error = static::t(
                        'To use the coupon, your order subtotal must be at least X',
                        array('min' => $currency->formatValue($coupon->getTotalRangeBegin()))
                    );

                } else {
                    $error = static::t(
                        'To use the coupon, your order subtotal must not exceed Y',
                        array('max' => $currency->formatValue($coupon->getTotalRangeEnd()))
                    );
                }

            } else {
                $error = static::t(
                    'There is no such a coupon, please check the spelling: X',
                    array('code' => func_htmlspecialchars($code))
                );
            }

        } else {
            $found = false;
            foreach ($this->getOrder()->getUsedCoupons() as $usedCoupon) {
                if (
                    $usedCoupon->getCoupon()
                    && $usedCoupon->getCoupon()->getId() == $coupon->getId()
                ) {
                    $found = true;
                    break;
                }
            }

            if ($found) {

                // Duplicate
                $error = static::t('You have already used the coupon');

            } else {
                $this->valid = true;
            }
        }

        $data = array(
            'error' => null,
        );

        if ($error) {
            $data['error'] = $error;

        } else {
            $data['amount'] = $coupon->getAmount($this->getOrder());
        }

        $this->setPureAction();

        $this->suppressOutput = true;
        $this->silent = true;

        print json_encode($data);
    }

    /**
     * Assemble coupon discount dump surcharge
     *
     * @return array
     */
    protected function assembleDcouponDumpSurcharge()
    {
        return $this->assembleDefaultDumpSurcharge(
            \XLite\Model\Base\Surcharge::TYPE_DISCOUNT,
            \XLite\Module\CDev\Coupons\Logic\Order\Modifier\Discount::MODIFIER_CODE,
            '\XLite\Module\CDev\Coupons\Logic\Order\Modifier\Discount',
            static::t('Coupon discount')
        );
    }

    /**
     * Get required surcharges
     *
     * @return array
     */
    protected function getRequiredSurcharges()
    {
        $result = parent::getRequiredSurcharges();

        $cnd = new \XLite\Core\CommonCell();
        $couponsCount = \XLite\Core\Database::getRepo('XLite\Module\CDev\Coupons\Model\Coupon')->search($cnd, true);

        if (0 < $couponsCount) {
            $result = array_merge(
                $result,
                array(\XLite\Module\CDev\Coupons\Logic\Order\Modifier\Discount::MODIFIER_CODE)
            );
        }

        return $result;
    }

    /**
     * Add human readable name for DCOUPON modifier code
     *
     * @return array
     */
    protected static function getFieldHumanReadableNames()
    {
        return array_merge(
            parent::getFieldHumanReadableNames(),
            array(
                \XLite\Module\CDev\Coupons\Logic\Order\Modifier\Discount::MODIFIER_CODE  => 'Coupon discount',
            )
        );
    }

    /**
     * Update order items list
     *
     * @param \XLite\Model\Order $order Order object
     *
     * @return void
     */
    protected function updateOrderItems($order)
    {
        $this->processCoupons($order);
        parent::updateOrderItems($order);
    }

    /**
     * Process coupons 
     * 
     * @param \XLite\Model\Order $order Order
     *  
     * @return void
     */
    protected function processCoupons(\XLite\Model\Order $order)
    {
        $request = \XLite\Core\Request::getInstance();

        // Remove coupon
        foreach ($order->getUsedCoupons() as $coupon) {
            $hash = md5($coupon->getCode());
            if ($coupon->getCode() && !empty($request->removeCoupons[$hash])) {
                // Register order change
                static::setOrderChanges(
                    'Removed coupons:' . $coupon->getId(),
                    $coupon->getCode()
                );
                // Remove used coupon from order
                $order->getUsedCoupons()->removeElement($coupon);
                \XLite\Core\Database::getEM()->remove($coupon);
            }
        }

        // Add coupon
        if (!empty($request->newCoupon) && is_array($request->newCoupon)) {

            foreach ($request->newCoupon as $code) {

                if ($code) {

                    $coupon = \XLite\Core\Database::getRepo('XLite\Module\CDev\Coupons\Model\Coupon')
                        ->findOneByCode($code);

                    if ($coupon) {
                        $usedCoupon = new \XLite\Module\CDev\Coupons\Model\UsedCoupon;
                        $usedCoupon->setOrder($order);
                        $order->addUsedCoupons($usedCoupon);
                        $usedCoupon->setCoupon($coupon);
                        $coupon->addUsedCoupons($usedCoupon);
                        \XLite\Core\Database::getEM()->persist($usedCoupon);

                        // Register order change
                        static::setOrderChanges(
                            'Added coupons:' . $coupon->getId(),
                            $coupon->getCode()
                        );
                    }
                }
            }
        }
    }

    /**
     * Assemble recalculate order event: Add coupons data
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return array
     */
    protected function assembleRecalculateOrderEvent(\XLite\Model\Order $order)
    {
        $result = parent::assembleRecalculateOrderEvent($order);

        $coupons = array();

        foreach ($order->getUsedCoupons() as $coupon) {
            $coupons[$coupon->getCode()] = abs($coupon->getValue());
        }

        if ($coupons) {
            $result['coupons'] = $coupons;
        }

        return $result;
    }
}
