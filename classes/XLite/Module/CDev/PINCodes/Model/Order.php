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

namespace XLite\Module\CDev\PINCodes\Model;

/**
 * Order
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * Returns true if the order has any pin codes
     *
     * @return boolean
     */
    public function hasPinCodes()
    {
        $result = false;

        foreach ($this->getItems() as $item) {
            if ($item->countPinCodes() || $item->getProduct()->getPinCodesEnabled()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Assign PIN codes to the order items
     *
     * @return void
     */
    public function acquirePINCodes()
    {
        $missingCount = 0;
        foreach ($this->getItems() as $item) {
            if ($item->getProduct()->getPinCodesEnabled() && !$item->countPinCodes()) {
                $item->acquirePinCodes();
                $missingCount += $item->countMissingPinCodes();
            }
        }

        if ($missingCount) {
             \XLite\Core\Mailer::sendAcquirePinCodesFailedAdmin($this);
             \XLite\Core\TopMessage::addError(
                 'Could not assign X PIN codes to order #Y.',
                 array(
                     'count'   => $missingCount,
                     'orderId' => $this->getOrderNumber(),
                 )
             );
        }
    }

    /**
     * Process PIN codes 
     * 
     * @return void
     */
    public function processPINCodes()
    {
        $missingCount = 0;
        foreach ($this->getItems() as $item) {
            if ($item->getProduct()->getPinCodesEnabled()) {
                if (!$item->countPinCodes()) {
                    $item->acquirePinCodes();
                    $missingCount += $item->countMissingPinCodes();
                }

                if ($item->countPinCodes()) {
                    $item->salePinCodes();
                }
            }
        }

        if ($missingCount) {
             \XLite\Core\Mailer::getInstance()->sendAcquirePinCodesFailedAdmin($this);
             \XLite\Core\TopMessage::addError(
                 'Could not assign X PIN codes to order #Y.',
                 array(
                     'count'   => $missingCount,
                     'orderId' => $this->getOrderNumber(),
                 )
             );
        }
    }

    /**
     * Called when an order successfully placed by a client
     *
     * @return void
     */
    public function processSucceed()
    {
        $this->acquirePINCodes();

        parent::processSucceed();
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processProcess()
    {
        $this->processPINCodes();

        parent::processProcess();
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processDeclinePIN()
    {
        $this->releasePINCodes();

        parent::processDecline();
    }

    /**
     * Release PIN codes linked to order items
     *
     * @return void
     */
    protected function releasePINCodes()
    {
        foreach ($this->getItems() as $item) {
            if ($item->getProduct()->getPinCodes()) {
                $item->releasePINCodes();
            }
        }
    }
}
