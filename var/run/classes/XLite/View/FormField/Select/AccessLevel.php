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

namespace XLite\View\FormField\Select;

/**
 * \XLite\View\FormField\Select\AccessLevel
 */
class AccessLevel extends \XLite\View\FormField\Select\Regular
{
    /**
     * Determines if this field is visible for customers or not
     *
     * @var boolean
     */
    protected $isAllowedForCustomer = false;


    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = \XLite\Core\Auth::getInstance()->getUserTypesRaw();

        foreach ($list as $k => $v) {
            if (
                !\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins') 
                && $k == \XLite\Core\Auth::getInstance()->getAdminAccessLevel()
            ) {
                unset($list[$k]);
            }else{
                $list[$k] = static::t($v);
            }
        }

        return $list;
    }

    /**
     * Check field value validity
     *
     * @return boolean
     */
    protected function checkFieldValue()
    {
        $isAllowedForCurrentUser = TRUE;
        if (!\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins')
            && $this->getValue() == \XLite\Core\Auth::getInstance()->getAdminAccessLevel()) {
            $isAllowedForCurrentUser = FALSE;
        }
        return $isAllowedForCurrentUser && in_array($this->getValue(), \XLite\Core\Auth::getInstance()->getAccessLevelsList());
    }
}
