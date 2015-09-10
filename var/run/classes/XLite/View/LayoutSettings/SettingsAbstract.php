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

namespace XLite\View\LayoutSettings;

/**
 * Layout settings
 */
abstract class SettingsAbstract extends \XLite\View\AView
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'layout_settings/settings/style.less';

        return $list;
    }

    /**
     * Returns current skin
     *
     * @return \XLite\Model\Module
     */
    public function getCurrentSkin()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Module')->getCurrentSkinModule();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'layout_settings/settings/body.tpl';
    }

    /**
     * Returns preview image url
     *
     * @return string
     */
    protected function getPreviewImageURL()
    {
        return \XLite\Core\Layout::getInstance()->getCurrentLayoutPreview();
    }

    /**
     * Returns current skin name
     *
     * @return string
     */
    protected function getCurrentSkinName()
    {
        $name = static::t('Standard');

        /** @var \XLite\Model\Module $module */
        $module = $this->getCurrentSkin();
        if ($module) {
            $name = \XLite\Core\Layout::getInstance()->getLayoutColorName() ?: $module->getModuleName();
        }

        return $name;
    }

    /**
     * Check show settings
     *
     * @return boolean
     */
    protected function showSettingsForm()
    {
        /** @var \XLite\Model\Module $module */
        $module = $this->getCurrentSkin();

        return $module && $module->callModuleMethod('showSettingsForm', false);
    }

    /**
     * Check has custom options
     *
     * @return boolean
     */
    protected function getSettingsForm()
    {
        /** @var \XLite\Model\Module $module */
        $module = $this->getCurrentSkin();

        return $module
            ? $module->getSettingsForm()
            : '';
    }
}
