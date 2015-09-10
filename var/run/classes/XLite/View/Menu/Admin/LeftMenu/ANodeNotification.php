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

namespace XLite\View\Menu\Admin\LeftMenu;

/**
 * Notification node abstract class
 */
abstract class ANodeNotification extends \XLite\View\AView
{
    /**
     * Widget params
     */
    const PARAM_LAST_READ = 'lastReadTimestamp';

    /**
     * Check if data is updated (must be fast)
     *
     * @return boolean
     */
    abstract public function isUpdated();

    /**
     * Returns count of unread messages
     *
     * @return integer
     */
    public function getUnreadCount()
    {
        return $this->isUpdated() ? 1 : 0;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'left_menu/node_notification.tpl';
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
            self::PARAM_LAST_READ => new \XLite\Model\WidgetParam\Int('Last read timestamp', 0),
        );
    }

    /**
     * Last read timestamp
     *
     * @return integer
     */
    protected function getLastReedTimestamp()
    {
        return $this->getParam(static::PARAM_LAST_READ);
    }

    // {{{ View helpers

    protected function getNodeTagAttributes()
    {
        $result['class'] = implode(' ', $this->getNodeStyleClasses());

        return $result;
    }

    /**
     * Returns node style class
     *
     * @return array
     */
    protected function getNodeStyleClasses()
    {
        $list = array('notification-item');

        if ($this->isUpdated()) {
            $list[] = 'updated';
        }

        return $list;
    }

    /**
     * Returns icon
     *
     * @return string
     */
    protected function getIcon()
    {
        return $this->getSVGImage('images/warning.svg');
    }

    /**
     * Returns header url
     *
     * @return string
     */
    protected function getHeaderUrl()
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
        return '';
    }

    /**
     * Get entries count
     *
     * @return integer
     */
    protected function getCounter()
    {
        return 0;
    }

    // }}}
}
