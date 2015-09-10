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

namespace XLite\Module\CDev\Wholesale\Model;

/**
 * Product variant
 *
 * @LC_Dependencies("XC\ProductVariants")
 */
class ProductVariant extends \XLite\Module\XC\ProductVariants\Model\ProductVariant implements \XLite\Base\IDecorator
{

    /**
     * Get minimum product quantity available to customer to purchase
     *
     * @param \XLite\Model\Membership $membership Customer's membership OPTIONAL
     *
     * @return integer
     */
    public function getMinQuantity($membership = null)
    {
        return $this->getProduct()->getMinQuantity($membership);
    }

    /**
     * Override clear price
     *
     * @return float
     */
    public function getClearPrice()
    {
        $price = parent::getClearPrice();

        if (
            $this->getProduct()->isWholesalePricesEnabled()
            && $this->isPersistent()
         ) {
            $membership = $this->getProduct()->getCurrentMembership();
            $wholesalePrice = $this->getDefaultPrice()
                ? $this->getProduct()->getWholesalePrice($membership)
                : \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')->getPrice(
                    $this,
                    $this->getProduct()->getWholesaleQuantity() ?: $this->getProduct()->getMinQuantity($membership),
                    $membership
                );

            if (!is_null($wholesalePrice)) {
                $price = $wholesalePrice;
            }
        }

        return $price;
    }

    /**
     * Return base price
     *
     * @return float
     */
    public function getBasePrice()
    {
        return parent::getClearPrice();
    }
}
