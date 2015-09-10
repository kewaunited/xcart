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

namespace XLite\Module\XC\ProductVariants\Core;

/**
 * XPayments client
 *
 */
class OrderHistory extends \XLite\Core\OrderHistory implements \XLite\Base\IDecorator
{
    /**
     * Register the change amount inventory
     *
     * @param integer              $orderId Order identifier
     * @param \XLite\Model\Product $product Product object
     * @param integer              $delta   Inventory delta changes
     *
     * @return void
     */
    public function registerChangeAmount($orderId, $product, $delta)
    {
        if (!$product->hasVariants()) {
            parent::registerChangeAmount($orderId, $product, $delta);
        }
    }

    /**
     * Register the change amount inventory
     *
     * @param integer                                               $orderId Order identifier
     * @param \XLite\Module\XC\ProductVariants\Model\ProductVariant $variant Product variant object
     * @param integer                                               $delta   Inventory delta changes
     *
     * @return void
     */
    public function registerChangeVariantAmount($orderId, $variant, $delta)
    {
        /** @var \XLite\Model\Product $product */
        $product = $variant->getProduct();
        $inventory = $product->getInventory();

        if (!$variant->getDefaultAmount() || $inventory->getEnabled()) {
            $this->registerEvent(
                $orderId,
                static::CODE_CHANGE_AMOUNT,
                $this->getOrderChangeAmountDescription($orderId, $delta, $inventory),
                $this->getOrderChangeAmountData($orderId, $product->getName(), $variant->getPublicAmount() - $delta, $delta)
            );
        }
    }
}
