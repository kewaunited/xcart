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

namespace XLite\Module\CDev\FedEx;

/**
 * Main
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getAuthorName()
    {
        return 'X-Cart team';
    }

    /**
     * Module name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getModuleName()
    {
        return 'FedEx';
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
     * Module version
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getMinorVersion()
    {
        return '3';
    }

    /**
     * Module description
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getDescription()
    {
        return 'Gets shipping quotes for FedEx delivery methods.';
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function showSettingsForm()
    {
        return true;
    }

    /**
     * Return link to settings form
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getSettingsForm()
    {
        return \XLite\Core\Converter::buildURL('fedex');
    }

    /**
     * Perform some actions at startup
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function init()
    {
        parent::init();

        // Register FedEx shipping processor
        \XLite\Model\Shipping::getInstance()->registerProcessor(
            '\XLite\Module\CDev\FedEx\Model\Shipping\Processor\FEDEX'
        );
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
}
