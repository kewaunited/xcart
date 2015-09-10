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
 * Module banner
 */
class ModuleBanner extends \XLite\View\AView
{
    const PARAM_MODULE_NAME = 'moduleName';
    const PARAM_CAN_CLOSE   = 'canClose';

    /**
     * Returns CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'module_banner/style.css';

        return $list;
    }

    /**
     * Returns JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'module_banner/controller.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'module_banner/body.tpl';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_MODULE_NAME    => new \XLite\Model\WidgetParam\String('Module name', null),
            static::PARAM_CAN_CLOSE => new \XLite\Model\WidgetParam\Bool('Can close', true),
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && !$this->isModuleInstalled()
            && !$this->isBannerClosed();
    }

    /**
     * Check module installed
     *
     * @return boolean
     */
    protected function isModuleInstalled()
    {
        return \Includes\Utils\ModulesManager::isModuleInstalled($this->getModuleName());
    }

    /**
     * Get module name
     *
     * @return string
     */
    protected function getModuleName()
    {
        return $this->getParam(static::PARAM_MODULE_NAME);
    }

    /**
     * Get alphanumeric module name
     *
     * @return string
     */
    protected function getStringModuleName()
    {
        return str_replace('\\', '_', $this->getModuleName());
    }

    /**
     * Check can close
     *
     * @return boolean
     */
    protected function isCanClose()
    {
        return (bool) $this->getParam(static::PARAM_CAN_CLOSE);
    }

    /**
     * Check banner is closed
     *
     * @return boolean
     */
    protected function isBannerClosed()
    {
        $closedModuleBanners = \XLite\Core\TmpVars::getInstance()->closedModuleBanners ?: array();

        return $this->isCanClose() && !empty($closedModuleBanners[$this->getModuleName()]);
    }

    /**
     * Get style class
     *
     * @return string
     */
    protected function getStyleClass()
    {
        return strtolower($this->getStringModuleName());
    }

    /**
     * Returns ACR URL
     *
     * @return string
     */
    protected function getModuleURL()
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
}
