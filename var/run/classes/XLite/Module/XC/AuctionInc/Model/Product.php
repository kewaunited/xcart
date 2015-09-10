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

namespace XLite\Module\XC\AuctionInc\Model;

/**
 * The "product" model class
 * @MappedSuperClass
 */
abstract class Product extends \XLite\Module\QSL\CloudSearch\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * AuctionInc related data
     *
     * @var \XLite\Module\XC\AuctionInc\Model\ProductAuctionInc
     *
     * @OneToOne (
     *     targetEntity="XLite\Module\XC\AuctionInc\Model\ProductAuctionInc",
     *     mappedBy="product",
     *     fetch="LAZY",
     *     cascade={"all"}
     * )
     */
    protected $auctionIncData;

    /**
     * Set auctionIncData
     *
     * @param XLite\Module\XC\AuctionInc\Model\ProductAuctionInc $auctionIncData
     * @return Product
     */
    public function setAuctionIncData(\XLite\Module\XC\AuctionInc\Model\ProductAuctionInc $auctionIncData = null)
    {
        $this->auctionIncData = $auctionIncData;
        return $this;
    }

    /**
     * Get auctionIncData
     *
     * @return XLite\Module\XC\AuctionInc\Model\ProductAuctionInc 
     */
    public function getAuctionIncData()
    {
        return $this->auctionIncData;
    }
}