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


namespace XLite\Module\XC\FreeShipping\Logic\Import\Processor;

/**
 * Decorate import processor
 */
class Products extends \XLite\Logic\Import\Processor\Products implements \XLite\Base\IDecorator
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

        $columns['freeShipping'] = array();
        $columns['freightFixedFee'] = array();

        return $columns;
    }

    // }}}

    // {{{ Verification

    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        return parent::getMessages()
            + array(
                'PRODUCT-FREE-SHIPPING-FMT' => 'Wrong free shipping format',
                'PRODUCT-FREIGHT-FIXED-FEE-FMT' => 'Wrong freight fixed fee format',
            );
    }

    /**
     * Verify 'free shipping' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyFreeShipping($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsBoolean($value)) {
            $this->addWarning('PRODUCT-FREE-SHIPPING-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Verify 'freightFixedFee' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyFreightFixedFee($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsFloat($value)) {
            $this->addWarning('PRODUCT-FREIGHT-FIXED-FEE-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Normalize 'freightFixedFee' value
     *
     * @param mixed $value Value
     *
     * @return float
     */
    protected function normalizeFreightFixedFeeValue($value)
    {
        return $this->normalizeValueAsFloat($value);
    }

    // }}}

    // {{{ Import

    /**
     * Import 'free shipping' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param string               $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importFreeShippingColumn(\XLite\Model\Product $model, $value, array $column)
    {
        $model->setFreeShip($this->normalizeValueAsBoolean($value));
    }

    // }}}
}
