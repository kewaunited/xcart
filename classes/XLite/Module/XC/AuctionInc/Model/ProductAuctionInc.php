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
 * Product inventory
 *
 * @Entity
 * @Table  (name="product_auction_inc",
 *      indexes={
 *          @Index (name="product_id", columns={"product_id"})
 *      }
 * )
 */
class ProductAuctionInc extends \XLite\Model\AEntity
{
    /**
     * Inventory unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Product (association)
     *
     * @var \XLite\Model\Product
     *
     * @OneToOne   (targetEntity="XLite\Model\Product", inversedBy="auctionIncData")
     * @JoinColumn (name="product_id", referencedColumnName="product_id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * Calculation method
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $calculationMethod = 'C';

    /**
     * Package
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $package = 'T';

    /**
     * Dimensions
     *
     * @var array
     *
     * @Column (type="array")
     */
    protected $dimensions = array(0, 0, 0);

    /**
     * Weight UOM
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=3)
     */
    protected $weightUOM = 'LBS';

    /**
     * Dimensions UOM
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=2)
     */
    protected $dimensionsUOM = 'IN';

    /**
     * Insurable
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $insurable = 'N';

    /**
     * Origin code
     *
     * @var string
     *
     * @Column (type="string", length=20)
     */
    protected $originCode = 'default';

    /**
     * On-demand
     *
     * @var array
     *
     * @Column (type="array")
     */
    protected $onDemand = array();

    /**
     * Supplemental item handling mode
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $supplementalItemHandlingMode = '';

    /**
     * Supplemental item handling code
     *
     * @var string
     *
     * @Column (type="string", length=20)
     */
    protected $supplementalItemHandlingCode;

    /**
     * Supplemental item handling fee
     *
     * @var float
     *
     * @Column (type="money", precision=14, scale=4)
     */
    protected $supplementalItemHandlingFee;

    /**
     * Carrier accessorial fees
     *
     * @var array
     *
     * @Column (type="array")
     */
    protected $carrierAccessorialFees = array();

    /**
     * Fixed fee mode
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $fixedFeeMode = 'F';

    /**
     * Fixed fee code
     *
     * @var string
     *
     * @Column (type="string", length=32)
     */
    protected $fixedFeeCode;

    /**
     * Fixed fee 1
     *
     * @var float
     *
     * @Column (type="money", precision=14, scale=4)
     */
    protected $fixedFee1;

    /**
     * Fixed fee 2
     *
     * @var float
     *
     * @Column (type="money", precision=14, scale=4)
     */
    protected $fixedFee2;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $config = \XLite\Core\Config::getInstance()->XC->AuctionInc;

        $this->setCalculationMethod($config->calculationMethod);
        $this->setPackage($config->package);
        $this->setInsurable($config->insurable);
        $this->setFixedFeeMode($config->fixedFeeMode);
        $this->setFixedFeeCode($config->fixedFeeCode);
        $this->setFixedFee1($config->fixedFee1);
        $this->setFixedFee2($config->fixedFee2);
    }

    /**
     * Set weight
     *
     * @param float $weight Weight
     *
     * @return void
     */
    public function setWeight($weight)
    {
        /** @var \XLite\Model\Product $product */
        $product = $this->getProduct();

        $product->setWeight($weight);
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        /** @var \XLite\Model\Product $product */
        $product = $this->getProduct();

        return $product->getWeight();
    }

    /**
     * Set dimensions
     *
     * @param array $dimensions Dimensions
     *
     * @return void
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = (is_array($dimensions) && 3 === count($dimensions))
            ? array_values($dimensions)
            : array(0, 0, 0);
    }

    /**
     * Get dimensions
     *
     * @return array
     */
    public function getDimensions()
    {
        return (is_array($this->dimensions) && 3 === count($this->dimensions))
            ? array_values($this->dimensions)
            : array(0, 0, 0);
    }
}
