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

namespace XLite\View\Menu\Admin\LeftMenu\Marketplace;

/**
 * Modules node
 */
class Modules extends \XLite\View\Menu\Admin\LeftMenu\ANodeNotification
{
    /**
     * Messages
     *
     * @var array
     */
    protected $messages = null;

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getMessages();
    }

    /**
     * Check if content is updated
     *
     * @return boolean
     */
    public function isUpdated()
    {
        return $this->getLastReedTimestamp() < $this->getLastUpdateTimestamp();
    }

    /**
     * Returns count of unread messages
     *
     * @return integer
     */
    public function getUnreadCount()
    {
        return array_reduce($this->getMessages(), array($this, 'countMessages'), 0);
    }

    /**
     * Get cache parameters
     *
     * @return array
     */
    public function getCacheParameters()
    {
        return array();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'left_menu/marketplace/modules.tpl';
    }

    /**
     * Get urgent messages
     *
     * @return array
     */
    protected function getMessages()
    {
        if (!isset($this->messages)) {
            $this->messages = array_map(array($this, 'parseMessage'), $this->fetchMessages());
            usort($this->messages, array($this, 'sortMessages'));

            $this->setLastUpdateTimestamp(array_reduce($this->messages, array($this, 'maxDate'), 0));
        }

        return $this->messages;
    }

    /**
     * Fetch messages
     *
     * @return array
     */
    protected function fetchMessages()
    {
        $result = array();
        $messages = \XLite\Core\Marketplace::getInstance()->getXC5Notifications();

        if ($messages) {
            foreach ($messages as $message) {
                if ($message['type'] == 'module') {
                    $result[] = $message;
                }
            }
        }

        return $result;
    }

    /**
     * Return update timestamp
     *
     * @return integer
     */
    protected function getLastUpdateTimestamp()
    {
        $result = \XLite\Core\TmpVars::getInstance()->modulesMessageLastTimestamp;

        if (!isset($result)) {
            $result = LC_START_TIME;
            \XLite\Core\TmpVars::getInstance()->modulesMessageLastTimestamp = $result;
        }

        return $result;
    }

    /**
     * Set update timestamp
     *
     * @param integer $timestamp Timestamp
     *
     * @return void
     */
    protected function setLastUpdateTimestamp($timestamp)
    {
        \XLite\Core\TmpVars::getInstance()->modulesMessageLastTimestamp = $timestamp;
    }

    /**
     * Parse message
     *
     * @param \SimpleXMLElement $message Message
     *
     * @return array
     */
    protected function parseMessage($message)
    {
        $message['external'] = true;

        if (!isset($message['link']) || empty($message['link'])) {
            $message['link'] = $this->getModuleURL($message['module']);
            $message['external'] = false;
        }

        return $message;
    }

    protected function getModuleURL($moduleName)
    {
        list($author, $module) = explode('-', $moduleName);
        list(, $limit) = $this->getWidget(array(), '\XLite\View\Pager\Admin\Module\Install')
            ->getLimitCondition()->limit;

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
     * Sort helper
     *
     * @param array $a First message
     * @param array $b Second message
     *
     * @return boolean
     */
    protected function sortMessages($a, $b)
    {
        return isset($a['date'])
            && isset($b['date'])
            && $a['date'] < $b['date'];
    }

    /**
     * Count helper
     *
     * @param integer $carry Carry
     * @param array   $item  Message
     *
     * @return integer
     */
    protected function countMessages($carry, $item)
    {
        if ($item['date'] >= $this->getLastReedTimestamp()) {
            $carry += 1;
        }

        return $carry;
    }

    /**
     * Max date helper
     *
     * @param integer $carry Carry
     * @param array   $item  Message
     *
     * @return integer
     */
    protected function maxDate($carry, $item)
    {
        return max($carry, $item['date']);
    }

    // {{{ View helpers

    /**
     * Returns node style class
     *
     * @return array
     */
    protected function getNodeStyleClasses()
    {
        $list = parent::getNodeStyleClasses();
        $list[] = 'modules';

        return $list;
    }

    /**
     * Returns icon
     *
     * @return string
     */
    protected function getIcon()
    {
        return '';
    }

    /**
     * Returns header
     *
     * @return string
     */
    protected function getHeader()
    {
        return static::t('New modules');
    }

    // }}}
}
