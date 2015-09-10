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
 * \XLite\View\FormField\Select\LayoutType
 */
class LayoutType extends \XLite\View\FormField\Select\Regular
{
    const PARAM_AVAILABLE_TYPES = 'availableTypes';

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/layout_type.css';

        return $list;
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/js/layout_type.js';

        return $list;
    }

    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            \XLite\Core\Layout::LAYOUT_TWO_COLUMNS_LEFT  => static::t('Two columns with left sidebar'),
            \XLite\Core\Layout::LAYOUT_TWO_COLUMNS_RIGHT => static::t('Two columns with right sidebar'),
            \XLite\Core\Layout::LAYOUT_THREE_COLUMNS     => static::t('Three columns'),
            \XLite\Core\Layout::LAYOUT_ONE_COLUMN        => static::t('One column'),
        );
    }

    /**
     * getOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        $availableTypes = $this->getParam(static::PARAM_AVAILABLE_TYPES);
        $options = parent::getOptions();

        $result = array();
        foreach ($options as $type => $label) {
            if (in_array($type, $availableTypes, true)) {
                $result[$type] = $label;
            }
        }

        return $result;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'layout_type.tpl';
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_AVAILABLE_TYPES => new \XLite\Model\WidgetParam\Collection(
                'Available types',
                array(),
                false
            ),
        );
    }

    /**
     * Get option classes
     *
     * @param mixed $value Value
     * @param mixed $text  Text
     *
     * @return array
     */
    protected function getOptionClasses($value, $text)
    {
        $result = 'layout-type ' . $value;
        if ($this->isOptionSelected($value)) {
            $result .= ' selected';
        }

        return $result;
    }

    /**
     * Returns layout type image
     *
     * @param string $value Layout type
     *
     * @return string
     */
    protected function getImage($value)
    {
        return $this->getSVGImage('images/layout/' . $value . '.svg');
    }

    /**
     * Returns layout preview for given type
     *
     * @param string $value Layout type
     *
     * @return string
     */
    protected function getPreviewImage($value)
    {
        return \XLite\Core\Layout::getInstance()->getLayoutPreview(
            \XLite\Core\Database::getRepo('XLite\Model\Module')->getCurrentSkinModule(),
            \XLite\Core\Layout::getInstance()->getLayoutColor(),
            $value
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && 1 < count($this->getParam(static::PARAM_AVAILABLE_TYPES));
    }
}
