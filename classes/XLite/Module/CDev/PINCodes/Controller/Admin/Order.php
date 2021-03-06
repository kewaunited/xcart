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

namespace XLite\Module\CDev\PINCodes\Controller\Admin;

/**
 * Order modify
 *
 */
class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $tpls = parent::getPageTemplates();

        if ($this->getOrder() && $this->getOrder()->hasPinCodes()) {
            $tpls += array(
                'pin_codes' => 'modules/CDev/PINCodes/order/pin_codes.tpl',
            );
        }

        return $tpls;
    }

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $pages = parent::getPages();

        if ($this->getOrder() && $this->getOrder()->hasPinCodes()) {
            $pages += array(
                'pin_codes' => static::t('PIN codes'),
            );
        }

        return $pages;
    }

    /**
     * Get order items
     *
     * @return array
     */
    public function getOrderItems()
    {
        return $this->getOrder()->getItems();
    }

    /**
     * Remove temporary order
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return void
     */
    protected function removeTemporaryOrder(\XLite\Model\Order $order)
    {
        foreach ($order->getItems() as $item) {
            foreach ($item->getPinCodes() as $pin) {
                \XLite\Core\Database::getEM()->remove($pin);
            }
        }

        parent::removeTemporaryOrder($order);
    }
}
