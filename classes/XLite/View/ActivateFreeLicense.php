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
 * \XLite\View\ActivateFreeLicense
 *
 * @ListChild (list="admin.center", zone="admin")
 *
 */
class ActivateFreeLicense extends \XLite\View\Dialog
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'activate_free_license';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'activate_free_license/style.css';

        return $list;
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Activate free license';
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'activate_free_license';
    }

    /**
     * Get default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'activate_free_license/body.tpl';
    }

    /**
     * Defines the modules list which will be disabled
     *
     * @return array
     */
    protected function getModulesList()
    {
        $result = array();

        $modules = \XLite\Core\Database::getRepo('XLite\Model\Module')->getBusinessEditionModulesList();

        foreach ($modules as $module) {
            $m = array();
            $m['iconURL']     = $module->getPublicIconURL();
            $m['moduleName']  = $module->getModuleName();
            $m['authorName']  = $module->getAuthorName();
            $m['isInstalled'] = $module->getInstalled();
            $m['isEnabled']   = $module->getEnabled();
            $m['pageURL']     = $module->getPageURL();
            $m['actualName']  = $module->getActualName();
            $result[] = $m;
        }

        $result[] = $this->getAOMEntry();
        $result[] = $this->getPTEntry();

        usort($result, array($this, 'sortModulesList'));

        return $result;
    }

    /**
     * Sort modules list
     *
     * @param array $a First module data
     * @param array $b Second module data
     *
     * @return integer
     */
    public function sortModulesList($a, $b)
    {
        $weight1 = $this->getModuleWeight($a['actualName']);
        $weight2 = $this->getModuleWeight($b['actualName']);

        if ($weight1 < $weight2) {
            $result = -1;

        } elseif ($weight1 > $weight2) {
            $result = 1;

        } else {
            $result = strcmp($a['moduleName'], $b['moduleName']);
        }

        return $result;
    }

    /**
     * Get module weight (used to sort modules list)
     *
     * @param string $moduleName Actual module name (string like 'author\name')
     *
     * @return integer
     */
    protected function getModuleWeight($moduleName)
    {
        $weights = array(
            'CDev\\Coupons'         => 10,
            'XC\\ProductVariants'   => 20,
            'XC\\CustomProductTabs' => 30,
            'XC\\Reviews'           => 40,
            'CDev\\Sale'            => 50,
            'AOM'                   => 1010,
            'PT'                    => 1020,
        );

        return isset($weights[$moduleName]) ? $weights[$moduleName] : 1000;
    }

    /**
     * Get AOM entry for modules list
     *
     * @return array
     */
    protected function getAOMEntry()
    {
        return array(
            'iconURL'     => $this->getShopURL() . '/skins/admin/en/images/icon_aom.png',
            'moduleName'  => static::t('Advanced Order Management'),
            'authorName'  => 'X-Cart team',
            'isInstalled' => true,
            'isEnabled'   => true,
            'actualName'  => 'AOM',
        );
    }

    /**
     * Get 'Payment transactions' entry for modules list
     *
     * @return array
     */
    protected function getPTEntry()
    {
        return array(
            'iconURL'     => $this->getShopURL() . '/skins/admin/en/images/icon_pt.png',
            'moduleName'  => static::t('Payment transactions'),
            'authorName'  => 'X-Cart team',
            'isInstalled' => true,
            'isEnabled'   => true,
            'actualName'  => 'PT',
        );
    }

    /**
     * Defines the default value for email
     *
     * @return string
     */
    protected function getEmail()
    {
        return \XLite\Core\Auth::getInstance()->getProfile()->getLogin();
    }

    /**
     * URL of the page where license can be purchased
     *
     * @return string
     */
    protected function getPurchaseURL()
    {
        return \XLite\Core\Marketplace::getPurchaseURL();
    }
}
