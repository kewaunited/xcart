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

namespace XLite\View;

/**
 * Header search
 *
 * @ListChild (list="admin.main.page.header.right", weight="100", zone="admin")
 */
class HeaderSearch extends \XLite\View\AView
{

    /**
     * Menu items 
     * 
     * @var array
     */
    protected $items; 

    /**
     * Get JS files 
     * 
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'main_center/page_container_parts/header_parts/header_search.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'main_center/page_container_parts/header_parts/header_search.tpl';
    }

    /**
     * Check widget visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Core\Auth::getInstance()->isAdmin();
    }

    /**
     * Get container tag attributes 
     * 
     * @return array
     */
    protected function getContainerTagAttributes()
    {
        return array(
            'class' => array('header-search'),
        );
    }

    /**
     * Get menu items 
     * 
     * @return array
     */
    protected function getMenuItems()
    {
        if (!isset($this->items)) {

            $this->items = array();

            $items = $this->defineMenuItems();

            $selIndex = null;

            foreach ($items as $k => $v) {

                if (\XLite\Controller\Admin\SearchRouter::isSearchCodeAllowed($v['code'])) {

                    $this->items[$k] = $v;

                    if (
                        is_null($selIndex)
                        && (
                            empty($_COOKIE['XCartAdminHeaderSearchType'])
                            || $_COOKIE['XCartAdminHeaderSearchType'] == $v['code']
                        )
                    ) {
                        $selIndex = $k;
                    }
                }
            }

            if (!is_null($selIndex)) {
                $this->items[$selIndex]['selected'] = true;
            }
        }

        return $this->items;
    }

    /**
     * Get menu items
     *
     * @return array
     */
    protected function defineMenuItems()
    {
        return array(
            array(
                'name'        => static::t('Products'),
                'code'        => 'product',
                'placeholder' => static::t('Products') . ' - p: key',
            ),
            array(
                'name'        => static::t('Users'),
                'code'        => 'profile',
                'placeholder' => static::t('Users') . ' - u: key',
            ),
            array(
                'name'        => static::t('Orders'),
                'code'        => 'order',
                'placeholder' => static::t('Orders') . ' - o: key',
            ),
        );
    }

    /**
     * Get current item 
     * 
     * @return array
     */
    protected function getCurrentItem()
    {
        $item = null;
        $list = $this->getMenuItems();
        foreach ($list as $v) {
            if (!empty($v['selected'])) {
                $item = $v;
                break;
            }
        }

        return $item;
    }
}
