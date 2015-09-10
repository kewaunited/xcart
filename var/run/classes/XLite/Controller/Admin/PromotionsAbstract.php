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

namespace XLite\Controller\Admin;

/**
 * Common promotions controller
 */
abstract class PromotionsAbstract extends \XLite\Controller\Admin\AAdmin
{
    /**
     * FIXME- backward compatibility
     *
     * @var array
     */
    protected $params = array('target', 'page');

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $page = $this->getPage();
        $pages = $this->getPages();

        return !empty($pages[$page]) ? $pages[$page] : static::t('Promotions');
    }

    /**
     * Returns purchase license URL
     *
     * @return string
     */
    public function getPurchaseLicenseURL()
    {
        return \XLite\Core\Marketplace::getPurchaseURL();
    }

    // {{{ Pages

    /**
     * Get pages static
     *
     * @return array
     */
    public static function getPagesStatic()
    {
        $list = array();

        if (\XLite::isFreeLicense()
            && \XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS)
        ) {
            $list['volume_discounts'] = array(
                'name' => static::t('Volume discounts'),
                'tpl' => 'promotions/volume_discounts.tpl',
            );

            $list['coupons'] = array(
                'name' => static::t('Coupons'),
                'tpl' => 'promotions/coupons.tpl',
            );
        }

        return $list;
    }

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = array();

        foreach (static::getPagesStatic() as $key => $page) {
            if ($this->checkPageACL($page)) {
                $list[$key] = $page['name'];
            }
        }

        return $list;
    }

    /**
     * Check page permissions and return true if page is allowed
     *
     * @param array $page Page data
     *
     * @return boolean
     */
    protected function checkPageACL($page)
    {
        $result = true;

        if (empty($page['public_access'])
            && !\XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS)
        ) {
            $result = !empty($page['permission'])
                && \XLite\Core\Auth::getInstance()->isPermissionAllowed($page['permission']);
        }

        return $result;
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = array();

        foreach (static::getPagesStatic() as $key => $page) {
            $list[$key] = $page['tpl'];
        }

        return $list;
    }

    // }}}
}
