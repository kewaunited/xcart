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

namespace XLite\Module\XC\ProductFilter\View\Model;

/**
 * Settings dialog model widget
 */
abstract class Settings extends \XLite\Module\CDev\SimpleCMS\View\Model\Settings implements \XLite\Base\IDecorator
{
    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        if (
            (
                'cache_management' === $this->getTarget()
                || (
                    'module' === $this->getTarget()
                    && $this->getModule()
                    && 'XC\ProductFilter' == $this->getModule()->getActualName()
                )
            )
            && \XLite\Core\Config::getInstance()->XC->ProductFilter->attributes_filter_by_category
            && \XLite\Core\Config::getInstance()->XC->ProductFilter->attributes_filter_cache_mode
        ) {
            $result['remove_product_filter_cache'] = new \XLite\View\Button\Tooltip(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL  => 'Remove product filter cache',
                    \XLite\View\Button\Regular::PARAM_ACTION => 'remove_product_filter_cache',
                    \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Remove product filter cache tooltip'),
                    \XLite\View\Button\AButton::PARAM_STYLE  => 'action always-enabled'
                )
            );
        }

        return $result;
    }

    /**
     * Get form field by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return array
     */
    protected function getFormFieldByOption(\XLite\Model\Config $option)
    {
        $cell = parent::getFormFieldByOption($option);

        switch ($option->getName()) {
            case 'attributes_filter_by_category':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'enable_attributes_filter' => array(true),
                    ),
                );
                break;

            case 'attributes_filter_cache_mode':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'attributes_filter_by_category' => array(true),
                        'enable_attributes_filter'      => array(true),
                    ),
                );
                break;
        }

        return $cell;
    }
}