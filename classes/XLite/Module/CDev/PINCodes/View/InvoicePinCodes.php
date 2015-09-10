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

namespace XLite\Module\CDev\PINCodes\View;

/**
 * Invoice item pin codes
 *
 * @ListChild (list="invoice.item.name", weight="200")
 * @ListChild (list="invoice.item.name", weight="30", zone="admin")
 */
class InvoicePinCodes extends \XLite\View\AView
{
    /**
     * Widget parameter names
     */
    const PARAM_ITEM = 'item';

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/PINCodes/invoice/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/PINCodes/invoice/pin_codes.tpl';
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
            self::PARAM_ITEM => new \XLite\Model\WidgetParam\Object('Order item', null, false, '\\XLite\\\Model\\OrderItem'),
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && (
                (!\XLite::isAdminZone() && 0 < count($this->getParam(self::PARAM_ITEM)->getSoldPinCodes()))
                || (\XLite::isAdminZone() && 0 < count($this->getParam(self::PARAM_ITEM)->getPinCodes()))
            );
    }

    /**
     * Get pin codes 
     * 
     * @return array
     */
    protected function getPinCodes()
    {
        $codes = array();

        $list = \XLite::isAdminZone()
            ? $this->getParam(self::PARAM_ITEM)->getPinCodes()
            : $this->getParam(static::PARAM_ITEM)->getSoldPinCodes();

        foreach ($list as $code) {
            $codes[] = $code->getCode();
        }

        return $codes;
    }

    /**
     * Get comma separated pin codes 
     *
     * @return string
     */
    protected function getCommaSeparatedPinCodes()
    {
        return implode(', ', $this->getPinCodes());
    }

}
