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

namespace XLite\View\Upgrade\Step\Prepare;

/**
 * APrepare
 */
abstract class APrepare extends \XLite\View\Upgrade\Step\AStep
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        // Must be called from this class
        if ($this->isUpgrade()) {
            $list[] = self::getDir() . '/css/upgrade.css';

        } else {
            $list[] = self::getDir() . '/css/style.css';
        }

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = self::getDir() . '/js/controller.js';

        return $list;
    }

    /**
     * Get directory where template is located (body.tpl)
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/prepare';
    }

    /**
     * Return internal list name
     *
     * @return string
     */
    protected function getListName()
    {
        return parent::getListName() . '.prepare';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getUpgradeEntries()
            && !\XLite\Upgrade\Cell::getInstance()->isUnpacked()
            && !\XLite\Upgrade\Cell::getInstance()->isUpgraded();
    }

    /**
     * Returns installed module url
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return string
     */
    protected function getInstalledModuleURL($module)
    {
        $pageId = \XLite\Core\Database::getRepo('XLite\Model\Module')
            ->getInstalledPageId(
                $module->getAuthor(),
                $module->getName(),
                \XLite\View\Pager\Admin\Module\Manage::getInstance()->getItemsPerPage()
            );

        $params = array(
            'clearCnd'                              => 1,
            \XLite\View\Pager\APager::PARAM_PAGE_ID => $pageId,
        );

        return \XLite::getInstance()->getShopURL(
            sprintf('%s#%s', $this->buildURL('addons_list_installed', '', $params), $module->getName())
        );
    }

    protected function isUpgrade()
    {
        return \XLite\Upgrade\Cell::getInstance()->isUpgrade();
    }
}
