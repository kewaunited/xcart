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

namespace XLite\Module\CDev\Paypal\View\FormField\Select;

/**
 * Protocol (http|https) selector
 */
class Protocol extends \XLite\View\FormField\Select\Regular
{
    /**
     * Return name of the folder with templates
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/CDev/Paypal/form_field/';
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'select_protocol.tpl';
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'http'  => static::t('http'),
            'https' => static::t('https'),
        );
    }

    /**
     * Get sign in return URL
     *
     * @param boolean $withProto If true - return URL with protocol (http|https), else - without protocol
     *
     * @return string
     */
    protected function getSignInReturnURL($withProto = true)
    {
        $api = new \XLite\Module\CDev\Paypal\Core\Login();

        $flag = $withProto
            ? null   // Get current value of Return URL
            : false; // Get Return URL with protocol 'http'

        $returnURL = $api->getSignInReturnURL($flag);

        if (!$withProto) {
            $returnURL = preg_replace('/^http/', '', $returnURL);
        }

        return $returnURL;
    }

    /**
     * Return true if it is allowed to change protocol of return URL
     *
     * @return boolean
     */
    protected function isEditableReturnURLProtocol()
    {
        return true;
    }
}
