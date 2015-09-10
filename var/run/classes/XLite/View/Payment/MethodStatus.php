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

namespace XLite\View\Payment;

/**
 * Payment configuration page
 */
class MethodStatus extends \XLite\View\AView
{
    const PARAM_METHOD = 'method';

    /**
     * Get css files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'payment/method_status/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'payment/method_status/body.tpl';
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
            self::PARAM_METHOD => new \XLite\Model\WidgetParam\Object(
                'Payment method',
                $this->getDefaultPaymentMethod(),
                false,
                '\XLite\Model\Payment\Method'
            ),
        );
    }

    /**
     * Return default payment method
     *
     * @return \XLite\Model\Payment\Method
     */
    protected function getDefaultPaymentMethod()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
            ->find(\XLite\Core\Request::getInstance()->method_id);
    }

    /**
     * Return current payment method
     *
     * @return \XLite\Model\Payment\Method
     */
    protected function getPaymentMethod()
    {
        return $this->getParam(static::PARAM_METHOD);
    }

    /**
     * Check visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getPaymentMethod();
    }

    /**
     * Returns style class
     *
     * @return string
     */
    protected function getClass()
    {
        return $this->isEnabled()
            ? 'alert alert-success'
            : 'alert alert-warning';
    }

    /**
     * Check if method is enabled
     *
     * @return boolean
     */
    protected function isEnabled()
    {
        $method = $this->getPaymentMethod();

        return $method && $method->isEnabled();
    }

    /**
     * Check if method is disabled
     *
     * @return boolean
     */
    protected function isDisabled()
    {
        return !$this->isEnabled();
    }

    /**
     * Returns 'before' list name (with payment method service name)
     *
     * @return string
     */
    protected function getBeforeListName()
    {
        $serviceName = $this->getPaymentMethod()->getServiceName();

        return 'payment_status.before.' . preg_replace('/[^\w]/', '_', $serviceName);
    }

    /**
     * Returns 'after' list name (with payment method service name)
     *
     * @return string
     */
    protected function getAfterListName()
    {
        $serviceName = $this->getPaymentMethod()->getServiceName();

        return 'payment_status.after.' . preg_replace('/[^\w]/', '_', $serviceName);
    }
}