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

namespace XLite\Module\XC\ColorSchemes;

/**
 * Module description
 *
 * @package XLite
 */
abstract class Main extends \XLite\Module\AModuleSkin
{
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
        return 'Color Schemes';
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
        return '5';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '3';
    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'This module adds three new color schemes to the base X-Cart design theme.';
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return false;
    }

    /**
     * The following pathes are defined as substitutional skins:
     *
     * admin interface:     skins/custom_skin/admin/en/
     * customer interface:  skins/custom_skin/default/en/
     * mail interface:      skins/custom_skin/mail/en
     *
     * @return array
     */
    public static function getSkins()
    {
        return array(
            \XLite::CUSTOMER_INTERFACE  => array('XC_ColorSchemes/default'),
        );
    }

    /**
     * Returns available layout colors
     *
     * @return array
     */
    public static function getLayoutColors()
    {
        return array(
            'Fashion' => \XLite\Core\Translation::lbl('Fashion'),
            'Noblesse' => \XLite\Core\Translation::lbl('Noblesse'),
            'Digital' => \XLite\Core\Translation::lbl('Digital'),
        );
    }

    /**
     * Defines the skin name
     * Currently it is defined from the configuration
     *
     * @return string
     */
    public static function getSkinName()
    {
        return \XLite\Core\Layout::getInstance()->getLayoutColor();
    }

    /**
     * Construct the CSS file name of the selected color scheme
     *
     * @return string
     */
    public static function getColorSchemeCSS()
    {
        return 'modules/XC/ColorSchemes/' . static::getSkinName() . '/style.css';
    }

    /**
     * Construct the Less file name of the selected color scheme
     *
     * @return string
     */
    public static function getColorSchemeLess()
    {
        return 'modules/XC/ColorSchemes/' . static::getSkinName() . '/style.less';
    }

    /**
     * Defines if the current skin is the default one
     *
     * @return boolean
     */
    public static function isDefaultColorScheme()
    {
        return !\XLite\Core\Layout::getInstance()->getLayoutColor();
    }
}
