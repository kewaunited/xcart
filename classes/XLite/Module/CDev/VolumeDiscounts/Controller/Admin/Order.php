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

namespace XLite\Module\CDev\VolumeDiscounts\Controller\Admin;

/**
 * Order page controller
 */
class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    /**
     * Assemble volume discount dump surcharge
     *
     * @return array
     */
    protected function assembleDiscountDumpSurcharge()
    {
        return $this->assembleDefaultDumpSurcharge(
            \XLite\Model\Base\Surcharge::TYPE_DISCOUNT,
            \XLite\Module\CDev\VolumeDiscounts\Logic\Order\Modifier\Discount::MODIFIER_CODE,
            '\XLite\Module\CDev\VolumeDiscounts\Logic\Order\Modifier\Discount',
            static::t('Discount')
        );
    }

    /**
     * Get required surcharges
     *
     * @return array
     */
    protected function getRequiredSurcharges()
    {
        return array_merge(
            parent::getRequiredSurcharges(),
            array(\XLite\Module\CDev\VolumeDiscounts\Logic\Order\Modifier\Discount::MODIFIER_CODE)
        );
    }

    /**
     * Add human readable name for DISCOUNT modifier code
     *
     * @return array
     */
    protected static function getFieldHumanReadableNames()
    {
        return array_merge(
            parent::getFieldHumanReadableNames(),
            array(
                \XLite\Module\CDev\VolumeDiscounts\Logic\Order\Modifier\Discount::MODIFIER_CODE  => 'Discount',
            )
        );
    }
}
