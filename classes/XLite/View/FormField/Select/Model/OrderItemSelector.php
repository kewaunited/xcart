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

namespace XLite\View\FormField\Select\Model;

/**
 * OrderItem selector widget
 */
class OrderItemSelector extends \XLite\View\FormField\Select\Model\ProductSelector
{

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[static::PARAM_PLACEHOLDER]->setValue(static::t('Enter product name or SKU'));
    }

    /**
     * Defines the name of the text value input
     *
     * @return string
     */
    protected function getTextName()
    {
        $name = $this->getParam(static::PARAM_NAME);
        $newName = preg_replace('/^(.+)\[(\w+)\]$/', '\\1[\\2_text]', $name);

        return $newName == $name ? $name . '_text' : $newName;
    }

    /**
     * Defines the URL to request the models
     *
     * @return string
     */
    protected function getDefaultGetter()
    {
        return $this->buildURL('model_order_item_selector');
    }

    /**
     * Get model defined template
     *
     * @return string
     */
    protected function getModelDefinedTemplate()
    {
        return 'order/page/parts/model_defined.tpl';
    }

    /**
     * Register the CSS classes to be set to the widget
     *
     * @return array
     */
    protected function defineCSSClasses()
    {
        $classes = parent::defineCSSClasses();

        $classes[] = 'no-validate';
        $classes[] = 'not-significant';

        return $classes;
    }

}
