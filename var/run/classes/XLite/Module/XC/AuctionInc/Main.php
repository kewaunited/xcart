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

namespace XLite\Module\XC\AuctionInc;

/**
 * AuctionInc module main class
 *
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Trial period duration (in seconds)
     * Default: 1 month (30 days)
     */
    const TRIAL_PERIOD_DURATION = 2592000;

    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'X-Cart team';
    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'AuctionInc ShippingCalc';
    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.2';
    }

    /**
     * Get minor core version which is required for the module activation
     *
     * @return string
     */
    public static function getMinorRequiredCoreVersion()
    {
        return '3';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '2';
    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return <<<TEXT
Provide your customers with accurate "real-time" comparative domestic or international shipping rates from
your choice of services from Fedex, UPS, USPS and DHL. No carrier accounts required. Full support for your
item dimensions and dimensional rates. Shipping origins from any country supported. A host of advanced
features include: shipping promotions, bundled handling fees, drop-shipping from multiple origins, and a
packaging engine that accurately predicts appropriate packaging for multiple items and quantities. Free
month-long trial, then subscription to AuctionInc required.
TEXT;
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return true;
    }

    /**
     * Return link to settings form
     *
     * @return string
     */
    public static function getSettingsForm()
    {
        return \XLite\Core\Converter::buildURL('auction_inc');
    }

    /**
     * Perform some actions at startup
     *
     * @return string
     */
    public static function init()
    {
        parent::init();

        \XLite\Model\Shipping::getInstance()->registerProcessor(
            '\XLite\Module\XC\AuctionInc\Model\Shipping\Processor\AuctionInc'
        );
    }

    /**
     * Method to call just after the module is installed
     *
     * @return void
     */
    public static function callInstallEvent()
    {
        static::generateHeaderReferenceCode();
        static::generateFirstUsageDate();
    }

    /**
     * The module is defined as the shipping module
     *
     * @return integer|null
     */
    public static function getModuleType()
    {
        return static::MODULE_TYPE_SHIPPING;
    }

    /**
     * Return true if module should work in strict mode
     * (strict mode enables the logging of errors like 'The module is not configured')
     *
     * @return boolean
     */
    public static function isStrictMode()
    {
        return false;
    }

    // {{{ HeaderReferenceCode

    /**
     * Generate first usage date
     *
     * @throws \Exception
     * @return string
     */
    public static function generateHeaderReferenceCode()
    {
        /** @var \XLite\Model\Repo\Config $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Config');
        $code = 'XC5-' . md5(LC_START_TIME);

        try {
            $repo->createOption(array(
                'category' => 'XC\AuctionInc',
                'name' => 'headerReferenceCode',
                'value' => 'XC5-' . md5(LC_START_TIME),
            ));
        } catch (\Exception $e) {
        }

        return $code;
    }

    /**
     * Returns HeaderReferenceCode
     *
     * @return string
     */
    public static function getHeaderReferenceCode()
    {
        return \XLite\Core\Config::getInstance()->XC->AuctionInc->headerReferenceCode
            ?: static::generateHeaderReferenceCode();
    }

    // }}}

    // {{{ XS trial period

    /**
     * Generate first usage date
     *
     * @throws \Exception
     * @return void
     */
    public static function generateFirstUsageDate()
    {
        /** @var \XLite\Model\Repo\Config $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Config');

        try {
            $repo->createOption(array(
                'category' => 'XC\AuctionInc',
                'name' => 'firstUsageDate',
                'value' => LC_START_TIME,
            ));
        } catch (\Exception $e) {
        }
    }

    /**
     * Check XS trial period
     *
     * @return boolean
     */
    public static function isXSTrialPeriodValid()
    {
        $firstUsageDate = \XLite\Core\Config::getInstance()->XC->AuctionInc->firstUsageDate;
        $result = true;

        if ($firstUsageDate) {
            $result = LC_START_TIME < $firstUsageDate + static::TRIAL_PERIOD_DURATION;

        } else {
            static::generateFirstUsageDate();
        }

        return $result;
    }

    /**
     * Check if SS available
     *
     * @return boolean
     */
    public static function isSSAvailable()
    {
        return (bool) \XLite\Core\Config::getInstance()->XC->AuctionInc->accountId;
    }

    /**
     * Check if XS available
     *
     * @return boolean
     */
    public static function isXSAvailable()
    {
        return !static::isSSAvailable()
            && static::isXSTrialPeriodValid()
            && (bool) \XLite\Core\Config::getInstance()->XC->AuctionInc->trialEnabled;
    }

    // }}}
}
