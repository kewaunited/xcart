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

namespace XLite\Controller\Customer;

/**
 * Order controller
 */
class Order extends \XLite\Controller\Customer\Base\Order
{
    /**
     * Cache of orders (for print invoice page)
     *
     * @var array
     */
    protected $orders = null;


    /**
     * Check - controller must work in secure zone or not
     *
     * @return boolean
     */
    public function isSecure()
    {
        return \XLite\Core\Config::getInstance()->Security->customer_security;
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->checkAccess()) {
            $title = static::t(
                'Order #X, Y',
                array(
                    'id'   => $this->getOrderNumber(),
                    'date' => \XLite\Core\Converter::getInstance()->formatTime($this->getOrder()->getDate()),
                )
            );

        } else {
            $title = static::t('Order not found');
        }

        return $title;
    }

    /**
     * Common method to determine current location
     *
     * @return string
     */
    protected function getLocation()
    {
        return static::t('Order details');
    }

    /**
     * getViewerTemplate
     *
     * @return string
     */
    protected function getViewerTemplate()
    {
        $result = parent::getViewerTemplate();

        if ('invoice' === \XLite\Core\Request::getInstance()->mode && $this->checkAccess()) {
            $result = 'common/print_invoice.tpl';
        }

        return $result;
    }

    /**
     * Get list of orders (to print invoices)
     *
     * @return array
     */
    public function getOrders()
    {
        if (!isset($this->orders)) {

            $result = array();

            if (!empty(\XLite\Core\Request::getInstance()->order_ids)) {
                $orderIds = explode(',', \XLite\Core\Request::getInstance()->order_ids);

                foreach ($orderIds as $orderId) {
                    $orderId = trim($orderId);
                    $order = \XLite\Core\Database::getRepo('XLite\Model\Order')->find(intval($orderId));
                    if ($order) {
                        $result[] = $order;
                    }
                }

            } else {
                $result[] = $this->getOrder();
            }

            $this->orders = $result;
        }

        return $this->orders;
    }

    /**
     * Return trus if page break is required after invoice page printing
     *
     * @param integer $index Index of order in the array of orders
     *
     * @return boolean
     */
    public function hasPageBreak($index)
    {
        return $index + 1 < count($this->orders);
    }
}
