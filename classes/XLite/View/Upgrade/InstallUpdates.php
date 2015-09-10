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

namespace XLite\View\Upgrade;

/**
 * InstallUpdates
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class InstallUpdates extends \XLite\View\Upgrade\AUpgrade
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/css/style.css';

        return $list;
    }

    /**
     * Get directory where template is located (body.tpl)
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/install_updates';
    }

    /**
     * Return internal list name
     *
     * @return string
     */
    protected function getListName()
    {
        return parent::getListName() . '.install_updates';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getUpgradeEntries() && $this->isUpdate();
    }

    /**
     * Return true if advanced mode is enabled
     *
     * @return boolean
     */
    protected function isAdvancedMode()
    {
        return (bool) \XLite\Core\Request::getInstance()->advanced;
    }

    /**
     * Return true if entry is selectable in the entries list (in advanced mode)
     *
     * @return boolean
     */
    protected function isEntrySelectable(\XLite\Upgrade\Entry\AEntry $entry)
    {
        return $this->isAdvancedMode()
            && (
                !$this->isModule($entry)
                || !(
                    $entry->isSystem()
                    && \XLite\Upgrade\Cell::getInstance()->hasCoreUpdate()
                )
            );
    }

    /**
     * Get URL for 'Advanced mode' button
     *
     * @return string
     */
    protected function getAdvancedModeURL()
    {
        $params = array(
            'mode'     => 'install_updates',
            'advanced' => 1,
        );

        return $this->buildURL('upgrade', '', $params);
    }

    /**
     * Get label for 'Advanced mode' button
     *
     * @return string
     */
    protected function getAdvancedModeButtonLabel()
    {
        return 'Advanced mode';
    }

    /**
     * Return true if 'Advanced mode' button should be displayed
     *
     * @return boolean
     */
    protected function isAdvancedModeButtonVisible()
    {
        return !$this->isAdvancedMode() && 1 < count($this->getUpgradeEntries());
    }

    /**
     * Get module ID
     *
     * @return string
     */
    protected function getModuleID(\XLite\Upgrade\Entry\AEntry $entry)
    {
        return $entry->getModuleEntryID();
    }
}
