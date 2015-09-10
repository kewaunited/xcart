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
 * Login page
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Login extends \XLite\View\AView
{
    /**
     * Time left to unlock
     *
     * @var integer
     */
    protected $timeLeftToUnlock;

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();

        $result[] = 'login';

        return $result;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'login/script.js';

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
        $list[] = 'unauthorized/style.less';
        $list[] = 'login/style.less';

        return $list;
    }

    /**
     * Check - login is locked or not
     *
     * @return integer
     */
    protected function isLocked()
    {
        return 0 < $this->getTimeLeftToUnlock();
    }

    /**
     * Return time left to unlock
     *
     * @return integer
     */
    protected function getTimeLeftToUnlock()
    {
        if (!isset($this->timeLeftToUnlock)) {
            $this->timeLeftToUnlock = \XLite\Core\Session::getInstance()->dateOfLockLogin
                ? \XLite\Core\Session::getInstance()->dateOfLockLogin + \XLite\Core\Auth::TIME_OF_LOCK_LOGIN - \XLite\Core\Converter::time()
                : 0;
        }

        return $this->timeLeftToUnlock;
    }

    /**
     * Return widget directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'login';
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/body.tpl';
    }
}
