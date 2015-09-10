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

namespace XLite\View;

/**
 * Widget generates content for order history event ORDER_EDITED
 */
class OrderEditHistoryData extends \XLite\View\AView
{
    /**
     *  Widget parameters names
     */
    const PARAM_CHANGES = 'changes';

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'order/history/order_changes.tpl';
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
            static::PARAM_CHANGES => new \XLite\Model\WidgetParam\Collection('Array of order changes', array()),
        );
    }

    /**
     * Get array if changes
     *
     * @return array
     */
    protected function getChanges()
    {
        return $this->getParam(static::PARAM_CHANGES);
    }

    /**
     * Return true is value is array
     *
     * @param mixed $value Value
     *
     * @return boolean
     */
    protected function isArray($value)
    {
        return is_array($value) && !(2 == count($value) && isset($value['old']) && isset($value['new']));
    }

    /**
     * Return true if subname should be displayed
     *
     * @param mixed $subname Subname
     *
     * @return boolean
     */
    protected function isDisplaySubname($subname)
    {
        return !is_numeric($subname);
    }
}
