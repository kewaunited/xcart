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

namespace XLite\Module\CDev\Coupons\View\Menu\Admin;

/**
 * Left menu widget
 */
class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    /**
     * Define quick links
     *
     * @return array
     */
    protected function defineQuickLinks()
    {
        $result = parent::defineQuickLinks();
        $result['add_new'][static::ITEM_CHILDREN]['add_coupon'] = array(
            static::ITEM_TITLE      => static::t('Coupon'),
            static::ITEM_ICON_SVG   => 'images/add_product.svg',
            static::ITEM_TARGET     => 'coupon',
            static::ITEM_WEIGHT     => 400,
            static::ITEM_PERMISSION => 'manage coupons',
        );

        return $result;
    }

    /**
     * Mark selected
     *
     * @param array $items Items
     *
     * @return array
     */
    protected function markSelected($items)
    {
        if ('coupon' == $this->getTarget()) {
            $this->selectedItem = array(
                'weight' => 10,
                'index'  => 'coupons',
            );
        }

        return parent::markSelected($items);
    }
}
