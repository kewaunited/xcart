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

namespace XLite\View\StickyPanel;

/**
 * Images settings dialog sticky panel
 */
class ImagesSettings extends \XLite\View\StickyPanel\ItemForm
{
    /**
     * Cached list of additional buttons
     *
     * @var array
     */
    protected $additionalButtons;

    /**
     * Define buttons widgets
     *
     * @return array
     */
    protected function defineButtons()
    {
        $list = parent::defineButtons() + $this->getAdditionalButtons();

        return $list;
    }

    /**
     * Get additional buttons
     *
     * @return array
     */
    protected function getAdditionalButtons()
    {
        if (!isset($this->additionalButtons)) {
            $this->additionalButtons = $this->defineAdditionalButtons();
        }

        return $this->additionalButtons;
    }

    /**
     * Define additional buttons
     * These buttons will be composed into dropup menu.
     * The divider button is also available: \XLite\View\Button\Divider
     *
     * @return array
     */
    protected function defineAdditionalButtons()
    {
        $list = array();

        $url = $this->buildURL('images', 'image_resize');

        $list[] = $this->getWidget(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL            => 'Generate resized images',
                \XLite\View\Button\AButton::PARAM_STYLE            => 'action always-enabled',
                \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Generate resized images help text'),
                \XLite\View\Button\Regular::PARAM_JS_CODE          => 'void(0);',
                \XLite\View\Button\AButton::PARAM_ATTRIBUTES       => array(
                    'data-url' => $url,
                ),
            ),
            '\XLite\View\Button\Tooltip'
        );

        return $list;
    }

    /**
     * Get class
     *
     * @return string
     */
    protected function getClass()
    {
        $class = parent::getClass();

        $class = trim($class . ' images-settings-panel');

        return $class;
    }
}
