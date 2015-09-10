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

namespace XLite\View\Button;

/**
 * Tooltip button
 */
class Tooltip extends \XLite\View\Button\Regular
{
    /**
     * Widget parameter names
     */
    const PARAM_BUTTON_TOOLTIP = 'buttonTooltip';
    const PARAM_SEPARATE_TOOLTIP = 'tooltip';

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/tooltip.css';

        return $list;
    }

    /**
     * Register files from common repository
     *
     * @return array
     */
    public function getCommonFiles()
    {
        $list = parent::getCommonFiles();
        $list[static::RESOURCE_JS][] = 'js/tooltip.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/tooltip.tpl';
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
            static::PARAM_BUTTON_TOOLTIP => new \XLite\Model\WidgetParam\String('Button tooltip', ''),
            static::PARAM_SEPARATE_TOOLTIP => new \XLite\Model\WidgetParam\String('Separate tooltip', ''),
        );
    }

    /**
     * Get class
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass()
            . ($this->getParam(static::PARAM_BUTTON_TOOLTIP) ? ' tooltip-caption' : '');
    }

    /**
     * Get class
     *
     * @return string
     */
    protected function getWrapperClass()
    {
        return 'button-tooltip'
            . ($this->getParam(static::PARAM_BUTTON_TOOLTIP) ? ' tooltip-main' : '');
    }

    /**
     * Get button tooltip
     *
     * @return string
     */
    protected function getButtonTooltip()
    {
        return $this->getParam(static::PARAM_BUTTON_TOOLTIP);
    }

    /**
     * Get separate tooltip
     *
     * @return string
     */
    protected function getSeparateTooltip()
    {
        return $this->getParam(static::PARAM_SEPARATE_TOOLTIP);
    }
}
