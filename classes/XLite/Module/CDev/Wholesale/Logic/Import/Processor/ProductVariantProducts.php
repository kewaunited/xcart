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

namespace XLite\Module\CDev\Wholesale\Logic\Import\Processor;

/**
 * Products
 *
 * @LC_Dependencies("XC\ProductVariants")
 */
abstract class ProductVariantProducts extends \XLite\Logic\Import\Processor\Products implements \XLite\Base\IDecorator
{
    // {{{ Columns

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $columns[static::VARIANT_PREFIX . 'WholesalePrices'] = array(
            static::COLUMN_IS_MULTIPLE => true,
            static::COLUMN_IS_MULTIROW => true,
        );

        return $columns;
    }

    // }}}

    // {{{ Verification

    /**
     * Verify 'wholesalePrices' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyVariantWholesalePrices($value, array $column)
    {
    }

    // }}}

    // {{{ Import

    /**
     * Import 'variantWholesalePrices' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param array                $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importVariantWholesalePricesColumn(\XLite\Model\Product $model, array $value, array $column)
    {
        foreach ($this->variants as $rowIndex => $variant) {
            foreach (\XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')->findByProductVariant($variant) as $price) {
                \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')->delete($price);
            }
            if (isset($value[$rowIndex])) {
                foreach ($value[$rowIndex] as $price) {
                    if (preg_match('/^(\d+)(-(\d+))?(\((.+)\))?=(\d+\.?\d*)$/iSs', $price, $m)) {
                        $price = new \XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice();
                        $price->setMembership($this->normalizeValueAsMembership($m[5]));
                        $price->setProductVariant($variant);
                        $price->setPrice($m[6]);
                        $price->setQuantityRangeBegin($m[1]);
                        $price->setQuantityRangeEnd((int) $m[3]);
                        \XLite\Core\Database::getEM()->persist($price);
                    }
                }
            }
        }
    }

    // }}}
}
