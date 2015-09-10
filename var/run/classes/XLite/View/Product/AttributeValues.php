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

namespace XLite\View\Product;

/**
 * Product attribute values
 */
class AttributeValues extends \XLite\View\AView
{
    /**
     * Widget param names
     */
    const PARAM_ORDER_ITEM = 'orderItem';
    const PARAM_PRODUCT    = 'product';
    const PARAM_IDX        = 'idx';

    /**
     * Multiple attributes
     *
     * @var array
     */
    protected $attributes;

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/style.css';

        return $list;
    }

    /**
     * Return widget directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'product/details/parts/attributes_modify';
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/body.tpl';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getAttributes();
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
            self::PARAM_ORDER_ITEM => new \XLite\Model\WidgetParam\Object(
                'Order item', null, false, '\XLite\Model\OrderItem'
            ),
            self::PARAM_PRODUCT => new \XLite\Model\WidgetParam\Object(
                'Product', null, false, '\XLite\Model\Product'
            ),
            self::PARAM_IDX => new \XLite\Model\WidgetParam\Int(
                'Index of order item', 0, false
            ),
        );
    }

    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    protected function getProduct()
    {
        $orderItem = $this->getParam(static::PARAM_ORDER_ITEM);

        return $orderItem
            ? $orderItem->getProduct()
            : (
                $this->getParam(static::PARAM_PRODUCT) ?: \XLite::getController()->getProduct()
            );
    }

    /**
     * Define attributes
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return $this->getProduct()->getEditableAttributes();
    }

    /**
     * Get attributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        if (!isset($this->attributes)) {
            $this->attributes = $this->defineAttributes();
        }

        return $this->attributes;
    }

    /**
     * Get order item index
     *
     * @return integer
     */
    protected function getIdx()
    {
        return $this->getParam(static::PARAM_IDX);
    }

    /**
     * Get order item index
     *
     * @return integer
     */
    protected function getCommonFieldName()
    {
        return 0 < $this->getParam(static::PARAM_IDX)
            ? 'order_items'
            : 'new';
    }

}
