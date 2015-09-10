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

namespace XLite\View\Page;

/**
 * Payment transactions page view
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class PaymentTransactions extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('payment_transactions'));
    }

    /**
     * Returns CSS style files
     *
     * @return string
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'payment_transactions/license_message.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'payment_transactions/body.tpl';
    }

    /**
     * Check - search box is visible or not
     *
     * @return boolean
     */
    protected function isSearchVisible()
    {
        return 0 < \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->count();
    }

    /**
     * Check if current page is accessible for current x-cart license
     *
     * @return boolean
     */
    protected function checkLicense()
    {
        return !\XLite::isFreeLicense();
    }

    /**
     * Show license message
     *
     * @return boolean
     */
    protected function showLicenseMessage()
    {
        return true;
    }

    /**
     * Returns license message template
     *
     * @return string
     */
    protected function getLicenseMessageTemplate()
    {
        return 'payment_transactions/license_message.tpl';
    }

    /**
     * Returns purchase license URL
     *
     * @return string
     */
    protected function getPurchaseLicenseURL()
    {
        return \XLite\Core\Marketplace::getPurchaseURL();
    }
}
