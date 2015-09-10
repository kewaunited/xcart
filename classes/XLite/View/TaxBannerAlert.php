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
 * Tax banner alert widget
 *
 * @ListChild (list="admin.center", zone="admin", weight="10")
 */
class TaxBannerAlert extends \XLite\View\ModuleBanner
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'tax_classes';
        $result[] = 'sales_tax';
        $result[] = 'vat_tax';

        return $result;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'tax_banner_alert/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'tax_banner_alert/body.tpl';
    }

    /**
     * Get module name
     *
     * @return string
     */
    protected function getModuleName()
    {
        return 'XC\\AvaTax';
    }

    /**
     * Get module id
     *
     * @return string
     */
    protected function getModuleId()
    {
        return $this->isModuleInstalled() && $this->getModule() ? $this->getModule()->getModuleId() : '';
    }

    /**
     * Get module id
     *
     * @return string
     */
    protected function getModule()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Module')->findOneByModuleName($this->getModuleName());
    }

    /**
     * Returns current target
     *
     * @return string
     */
    protected function getModuleSettingsLink()
    {
        $link = '';
        if ($this->isModuleInstalled()) { // enabled, actually
            $link = $this->buildURL(
                'module',
                '',
                array(
                    "moduleId"      => $this->getModuleId(),
                    "returnTarget"  => $this->getCurrentTarget(),
                )
            );
        } elseif ($this->getModule() && $this->getModule()->isInstalled()) { // installed
            $link = $this->buildURL(
                'addons_list_installed',
                '',
                array(
                    "clearCnd"  => 1,
                    "pageId"    => 1,
                )
            ) . "#" . $this->getModule()->getName();
        } else { // not installed
            $link = $this->getModuleMarketplaceLink();
        }
        return $link;
    }

    /**
     * Return Module link
     *
     * @return string
     */
    protected function getModuleMarketplaceLink()
    {
        list(, $limit) = $this->getWidget(array(), 'XLite\View\Pager\Admin\Module\Install')
            ->getLimitCondition()->limit;

        list($author, $module) = explode('\\', $this->getModuleName());
        $pageId = \XLite\Core\Database::getRepo('XLite\Model\Module')->getMarketplacePageId($author, $module, $limit);

        return $this->buildURL(
            'addons_list_marketplace',
            '',
            array(
                'clearCnd'                                      => 1,
                'clearSearch'                                   => 1,
                \XLite\View\Pager\APager::PARAM_PAGE_ID         => $pageId,
                \XLite\View\ItemsList\AItemsList::PARAM_SORT_BY => \XLite\View\ItemsList\Module\AModule::SORT_OPT_ALPHA,
            )
        ) . '#' . $module;
    }

    /**
     * Returns current target
     *
     * @return string
     */
    protected function getCurrentTarget()
    {
        return \XLite\Core\Request::getInstance()->target;
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return \XLite\View\AView::isVisible()
            && !$this->isBannerClosed()
            && \XLite\Controller\Admin\TaxClasses::isEnabled();
    }
}
