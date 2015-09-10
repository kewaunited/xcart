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

namespace XLite\View\Order\Details\Admin;

/**
 * Order modifier widget
 */
class Modifier extends \XLite\View\AView
{
    /**
     * Widget parameters
     */
    const PARAM_ORDER          = 'order';
    const PARAM_SURCHARGE      = 'surcharge';
    const PARAM_SURCHARGE_TYPE = 'sType';


    /**
     * Return default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'order/page/parts/totals.modifier.default.tpl';
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
            self::PARAM_ORDER          => new \XLite\Model\WidgetParam\Object(
                'Order', null, false, '\XLite\Model\Order'
            ),
            self::PARAM_SURCHARGE      => new \XLite\Model\WidgetParam\Collection(
                'Order surcharge', array(), false, '\XLite\Model\Order\Surcharge'
            ),
            self::PARAM_SURCHARGE_TYPE => new \XLite\Model\WidgetParam\String(
                'Surcharge type', '', false
            ),
        );
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder()
    {
        return $this->getParam(self::PARAM_ORDER);
    }

    /**
     * Get surcharge
     *
     * @return \XLite\Model\Order\Surcharge
     */
    protected function getSurcharge()
    {
        return $this->getParam(self::PARAM_SURCHARGE);
    }

    /**
     * Get surcharge type
     *
     * @return string
     */
    protected function getSurchargeType()
    {
        return $this->getParam(self::PARAM_SURCHARGE_TYPE);
    }

    /**
     * Format surcharge value
     *
     * @param array $surcharge Surcharge
     *
     * @return string
     */
    protected function formatSurcharge(array $surcharge)
    {
        return $this->formatPrice(abs($surcharge['cost']), $this->getOrder()->getCurrency(), !\XLite::isAdminZone());
    }

}
