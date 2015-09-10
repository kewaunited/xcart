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
 * EntriesList
 *
 * @ListChild (list="admin.center", weight="100", zone="admin")
 */
class EntriesList extends \XLite\View\Upgrade\Step\Prepare\APrepare
{
    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/js/widget.js';

        return $list;
    }

    /**
     * Get directory where template is located (body.tpl)
     *
     * @return string
     */
    protected function getDir()
    {
        return $this->isUpgrade()
            ? parent::getDir() . '/entries_list_upgrade'
            : parent::getDir() . '/entries_list_update';
    }

    /**
     * Return internal list name
     *
     * @return string
     */
    protected function getListName()
    {
        return $this->isUpgrade()
            ? parent::getListName() . '.entries_list_upgrade'
            : parent::getListName() . '.entries_list_update';
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        if (\XLite\Upgrade\Cell::getInstance()->isUpgrade()) {
            $result = static::t(
                'X modules will be upgraded',
                array('count' => $this->getUpgradeEntriesCount())
            );

        } else {
            $result = 'These components will be updated';
        }

        return $result;
    }

    /**
     * Helper to get CSS class
     *
     * @param \XLite\Upgrade\Entry\AEntry $entry Current entry
     *
     * @return string
     */
    protected function getEntryRowCSSClass(\XLite\Upgrade\Entry\AEntry $entry)
    {
        return $this->isModule($entry) ? 'module-entry' : 'core-entry';
    }
}
