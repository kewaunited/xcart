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

namespace XLite\Module\XC\AuctionInc\View\Order;

/**
 * Order modifier widget
 */
class Package extends \XLite\View\AView
{
    /**
     * Widget parameters
     */
    const PARAM_PACKAGE = 'package';
    const PARAM_INDEX   = 'index';
    const PARAM_ORDER   = 'order';

    /**
     * Returns CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/AuctionInc/order/package/style.css';

        return $list;
    }

    /**
     * Return default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/AuctionInc/order/package/body.tpl';
    }

    /**
     * Define widget parameters
     *
     * @return array
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PACKAGE => new \XLite\Model\WidgetParam\Collection('Package', array()),
            static::PARAM_INDEX   => new \XLite\Model\WidgetParam\Int('Index', 0),
            static::PARAM_ORDER   => new \XLite\Model\WidgetParam\Object('Order', null, false, '\XLite\Model\Order'),
        );
    }

    /**
     * Returns package
     *
     * @return array
     */
    protected function getPackage()
    {
        return $this->getParam(static::PARAM_PACKAGE);
    }

    /**
     * Returns package
     *
     * @return array
     */
    protected function getIndex()
    {
        return $this->getParam(static::PARAM_INDEX) + 1;
    }

    /**
     * Returns order
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder()
    {
        return $this->getParam(static::PARAM_ORDER);
    }

    /**
     * Returns available fields
     *
     * @return array
     */
    protected function getAvailableFields()
    {
        return array(
            'DeclaredValue',
            'Quantity',
            'Weight',
            'Length',
            'Width',
            'Height',
            'CarrierRate',
            'Surcharge',
            'FuelSurcharge',
            'Insurance',
            'Handling',
            'ShipRate',
            'FixedRate',
            'PackMethod',
            'Origin',
            'OversizeCode',
            'FlatRateCode',
        );
    }

    /**
     * Returns package fields
     *
     * @return array
     */
    protected function getPackageFields()
    {
        $fields = array_intersect_key(
            $this->getPackage(),
            array_flip($this->getAvailableFields())
        );

        if (isset($fields['PackMethod'])) {
            $fields['PackMethod'] = 'S' === $fields['PackMethod'] ? 'Separately' : 'Together';
        }

        return $fields;
    }

    /**
     * Returns package items
     *
     * @return array
     */
    protected function getPackageItems()
    {
        $result = array();

        $package = $this->getPackage();
        $packageItems = isset($package['PkgItem']) ? $package['PkgItem'] : array();

        foreach ($packageItems as $item) {
            $sku = $item['RefCode'];

            $result[] = array(
                'item' => $this->getItemBySKU($sku),
                'sku'  => $sku,
                'qty' => $item['Qty'],
                'weight' => $item['Weight'],
            );
        }

        return $result;
    }

    // {{{ getItemBySKU

    /**
     * Check item sku equal
     *
     * @param \XLite\Model\OrderItem $item Order item
     * @param string                 $sku  Sku
     *
     * @return boolean
     */
    public function checkItemSKUEqual(\XLite\Model\OrderItem $item, $sku)
    {
        return $item->getSKU() == $sku;
    }

    /**
     * Returns item by sku
     *
     * @param string $sku Sku
     *
     * @return array
     */
    protected function getItemBySKU($sku)
    {
        $items = $this->getOrder()->getItems();

        return \Includes\Utils\ArrayManager::findValue(
            $items,
            array($this, 'checkItemSKUEqual'),
            $sku
        );
    }

    // }}}
}
