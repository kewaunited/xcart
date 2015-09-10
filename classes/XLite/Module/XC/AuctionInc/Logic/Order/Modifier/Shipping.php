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

namespace XLite\Module\XC\AuctionInc\Logic\Order\Modifier;

/**
 * Shipping modifier
 */
class Shipping extends \XLite\Logic\Order\Modifier\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Shipping rates sorting callback
     *
     * @param \XLite\Model\Shipping\Rate $a First shipping rate
     * @param \XLite\Model\Shipping\Rate $b Second shipping rate
     *
     * @return integer
     */
    protected function compareRates(\XLite\Model\Shipping\Rate $a, \XLite\Model\Shipping\Rate $b)
    {
        $aRate = $a->getTotalRate();
        $bRate = $b->getTotalRate();

        return $aRate == $bRate
            ? 0
            : ($aRate < $bRate ? -1 : 1);
    }

    /**
     * Set shipping rate and shipping method id
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate object OPTIONAL
     *
     * @return void
     */
    public function setSelectedRate(\XLite\Model\Shipping\Rate $rate = null)
    {
        parent::setSelectedRate($rate);

        $package = $rate && $rate->getExtraData() && $rate->getExtraData()->auctionIncPackage
            ? $rate->getExtraData()->auctionIncPackage
            : array();

        $this->order->setAuctionIncPackage($package);
    }

    /**
     * Restore rates
     *
     * @return array(\XLite\Model\Shipping\Rate)
     */
    protected function restoreRates()
    {
        $rates = parent::restoreRates();

        if ($rates && $this->order->getAuctionIncPackage()) {
            $extraData = new \XLite\Core\CommonCell(array('auctionIncPackage' => $this->order->getAuctionIncPackage()));
            $rates[0]->setExtraData($extraData);
        }

        return $rates;
    }
}
