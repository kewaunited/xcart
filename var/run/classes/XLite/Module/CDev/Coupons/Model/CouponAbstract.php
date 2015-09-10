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

namespace XLite\Module\CDev\Coupons\Model;

/**
 * @MappedSuperClass (repositoryClass="\XLite\Module\CDev\Coupons\Model\Repo\Coupon")
 */
abstract class CouponAbstract extends \XLite\Model\AEntity
{
    /**
     * Coupon types
     */
    const TYPE_PERCENT  = '%';
    const TYPE_ABSOLUTE = '$';

    /**
     * Coupon validation crror codes
     */
    const ERROR_DISABLED      = 'disabled';
    const ERROR_EXPIRED       = 'expired';
    const ERROR_USES          = 'uses';
    const ERROR_TOTAL         = 'total';
    const ERROR_PRODUCT_CLASS = 'product_class';
    const ERROR_MEMBERSHIP    = 'membership';
    const ERROR_SINGLE_USE    = 'singleUse';
    const ERROR_SINGLE_USE2   = 'singleUse2';
    const ERROR_CATEGORY      = 'category';


    /**
     * Product unique ID
     *
     * @var   integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Code
     *
     * @var   string
     *
     * @Column (type="string", options={ "fixed": true }, length=16)
     */
    protected $code;

    /**
     * Enabled status
     *
     * @var   boolean
     *
     * @Column (type="boolean")
     */
    protected $enabled = true;

    /**
     * Value
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $value = 0.0000;

    /**
     * Type
     *
     * @var   string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $type = self::TYPE_PERCENT;

    /**
     * Comment
     *
     * @var   string
     *
     * @Column (type="string", length=64)
     */
    protected $comment = '';

    /**
     * Uses count
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $uses = 0;

    /**
     * Date range (begin)
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $dateRangeBegin = 0;

    /**
     * Date range (end)
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $dateRangeEnd = 0;

    /**
     * Total range (begin)
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $totalRangeBegin = 0;

    /**
     * Total range (end)
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $totalRangeEnd = 0;

    /**
     * Uses limit
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $usesLimit = 0;

    /**
     * Flag: Can a coupon be used together with other coupons (false) or no (true)
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $singleUse = false;

    /**
     * Product classes
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\ProductClass", inversedBy="coupons")
     * @JoinTable (name="product_class_coupons",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="class_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $productClasses;

    /**
     * Memberships
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\Membership", inversedBy="coupons")
     * @JoinTable (name="membership_coupons",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="membership_id", referencedColumnName="membership_id", onDelete="CASCADE")}
     * )
     */
    protected $memberships;

    /**
     * Used coupons
     *
     * @var   \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\CDev\Coupons\Model\UsedCoupon", mappedBy="coupon")
     */
    protected $usedCoupons;

    /**
     * Categories
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\Category", inversedBy="coupons")
     * @JoinTable (name="coupon_categories",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="category_id", referencedColumnName="category_id", onDelete="CASCADE")}
     * )
     */
    protected $categories;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->productClasses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->memberships    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usedCoupons    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories     = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    // {{{ Logic

    /**
     * Check - discount is absolute or not
     *
     * @return boolean
     */
    public function isAbsolute()
    {
        return static::TYPE_ABSOLUTE == $this->getType();
    }

    /**
     * Check coupon activity
     *
     * @param \XLite\Model\Order $order Order OPTIONAL
     *
     * @return boolean
     */
    public function isActive(\XLite\Model\Order $order = null)
    {
        return 0 == count($this->getErrorCodes($order));
    }

    /**
     * Get coupon error codes
     *
     * @param \XLite\Model\Order $order Order OPTIONAL
     *
     * @return array
     */
    public function getErrorCodes(\XLite\Model\Order $order = null)
    {
        $result = array();

        if (!$this->getEnabled()) {
            $result[] = self::ERROR_DISABLED;
        }

        if (
            (0 < $this->getDateRangeBegin() && $this->getDateRangeBegin() > \XLite\Core\Converter::time())
            || $this->isExpired()
        ) {
            $result[] = self::ERROR_EXPIRED;
        }

        if (0 < $this->getUsesLimit() && $this->getUsesLimit() <= $this->getUses()) {
            $result[] = self::ERROR_USES;
        }

        if ($order) {

            // Check by order

            $result += $this->getSingleUseErrors($order);

            $result += $this->getOrderErrors($order);

            $result += $this->getCategoryErrors($order);

            $result += $this->getMembershipErrors($order);

            $result += $this->getProductClassErrors($order);
        }

        return $result;
    }

    /**
     * Check - coupon is expired or not
     *
     * @return boolean
     */
    public function isExpired()
    {
        return 0 < $this->getDateRangeEnd() && $this->getDateRangeEnd() < \XLite\Core\Converter::time();
    }

    /**
     * Get amount
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    public function getAmount(\XLite\Model\Order $order)
    {
        $total = $this->getOrderTotal($order);

        return $this->isAbsolute()
            ? min($total, $this->getValue())
            : ($total * $this->getValue() / 100);
    }

    /**
     * Return true if order item is valid for coupon
     *
     * @param \XLite\Model\OrderItem $orderItem Order item model
     *
     * @return boolean
     */
    public function isValidItem($item)
    {
        $result = true;

        if (0 < count($this->getProductClasses())) {
            // Check product class
            $result = $item->getProduct()->getProductClass()
                && $this->getProductClasses()->contains($item->getProduct()->getProductClass());
        }

        if ($result && 0 < count($this->getCategories())) {
            // Check categories
            $result = false;
            foreach ($item->getProduct()->getCategories() as $cat) {
                if ($this->getCategories()->contains($cat)) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get order total
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    protected function getOrderTotal(\XLite\Model\Order $order)
    {
        $total = 0;
        $items = $this->getValidOrderItems($order);

        foreach ($items as $item) {
            $total += $item->getSubtotal();
        }

        return $total;
    }

    /**
     * Get order items which are valid for the coupon
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return array
     */
    protected function getValidOrderItems($order)
    {
        $items = array();

        foreach ($order->getItems() as $item) {
            if ($this->isValidItem($item)) {
                $items[] = $item;
            }
        }

        return $items;
    }

    // }}}

    /**
     * Get the singleUse error
     *
     * @param \XLite\Model\Order $order Order model
     *
     * @return array
     */
    protected function getSingleUseErrors(\XLite\Model\Order $order)
    {
        $result = array();

        $usedCoupons = $order->getUsedCoupons();

        if ($this->getSingleUse() && 0 < $usedCoupons->count()) {
            $found = false;
            foreach ($usedCoupons as $uc) {
                if ($uc->getCoupon() && $this->getCode() != $uc->getCoupon()->getCode()) {
                    // Other coupon was found in the order
                    $found = true;
                    break;
                }
            }
            if ($found) {
                // Coupon can not be added to order together with other coupons
                $result[] = self::ERROR_SINGLE_USE;
            }

        } elseif (0 < $usedCoupons->count()) {
            $found = false;
            foreach ($usedCoupons as $uc) {
                if ($uc->getCoupon() && $uc->getCoupon()->getSingleUse()) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                // Coupon can not be added as order contains singleUse-coupon
                $result[] = self::ERROR_SINGLE_USE2;
            }
        }

        return $result;
    }

    /**
     * Get the common order errors
     *
     * @param \XLite\Model\Order $order
     *
     * @return array
     */
    protected function getOrderErrors(\XLite\Model\Order $order)
    {
        $result = array();

        $total = $this->getOrderTotal($order);

        if (
            (0 < $this->getTotalRangeBegin() && $this->getTotalRangeBegin() > $total)
            || (0 < $this->getTotalRangeEnd() && $this->getTotalRangeEnd() < $total)
        ) {
            $result[] = self::ERROR_TOTAL;
        }

        return $result;
    }

    /**
     * Get the errors which are connected with the membership of the user who placed the order
     *
     * @param \XLite\Model\Order $order
     *
     * @return array
     */
    protected function getMembershipErrors(\XLite\Model\Order $order)
    {
        $found = true;

        $memberships = $this->getMemberships();

        // Memberhsip
        if (0 < count($memberships)) {

            $membership = $order->getProfile() ? $order->getProfile()->getMembership() : null;

            $found = $membership
                ? \Includes\Utils\ArrayManager::findValue(
                    $memberships,
                    array($this, 'checkMembershipId'),
                    $membership->getMembershipId()
                ) : false;
        }

        return $found ? array() : array(static::ERROR_MEMBERSHIP);
    }

    /**
     * Get the errors which are connected with the product classes of products in order
     *
     * @param \XLite\Model\Order $order
     *
     * @return array
     */
    protected function getProductClassErrors(\XLite\Model\Order $order)
    {
        $found = true;

        // Product classes
        if (0 < count($this->getProductClasses())) {

            $found = false;

            foreach ($order->getItems() as $item) {

                $found = $item->getProduct()->getProductClass()
                    && $this->getProductClasses()->contains($item->getProduct()->getProductClass());

                if ($found) {
                    break;
                }
            }
        }

        return $found ? array() : array(static::ERROR_PRODUCT_CLASS);
    }

    /**
     * Get the errors related to categories of products in order
     *
     * @param \XLite\Model\Order $order
     *
     * @return array
     */
    protected function getCategoryErrors(\XLite\Model\Order $order)
    {
        $found = true;

        // Categories
        if (0 < count($this->getCategories())) {

            $found = false;

            foreach ($order->getItems() as $item) {

                foreach ($item->getProduct()->getCategories() as $cat) {
                    if ($this->getCategories()->contains($cat)) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    break;
                }
            }
        }

        return $found ? array() : array(static::ERROR_CATEGORY);
    }

    /**
     * Check membership item id equal
     *
     * @param \XLite\Model\Membership $item
     * @param type $membershipId
     *
     * @return boolean
     */
    public function checkMembershipId(\XLite\Model\Membership $item, $membershipId)
    {
        return $item->getMembershipId() === $membershipId;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Coupon
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Coupon
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set value
     *
     * @param decimal $value
     * @return Coupon
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return decimal 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Coupon
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Coupon
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set uses
     *
     * @param integer $uses
     * @return Coupon
     */
    public function setUses($uses)
    {
        $this->uses = $uses;
        return $this;
    }

    /**
     * Get uses
     *
     * @return integer 
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Set dateRangeBegin
     *
     * @param integer $dateRangeBegin
     * @return Coupon
     */
    public function setDateRangeBegin($dateRangeBegin)
    {
        $this->dateRangeBegin = $dateRangeBegin;
        return $this;
    }

    /**
     * Get dateRangeBegin
     *
     * @return integer 
     */
    public function getDateRangeBegin()
    {
        return $this->dateRangeBegin;
    }

    /**
     * Set dateRangeEnd
     *
     * @param integer $dateRangeEnd
     * @return Coupon
     */
    public function setDateRangeEnd($dateRangeEnd)
    {
        $this->dateRangeEnd = $dateRangeEnd;
        return $this;
    }

    /**
     * Get dateRangeEnd
     *
     * @return integer 
     */
    public function getDateRangeEnd()
    {
        return $this->dateRangeEnd;
    }

    /**
     * Set totalRangeBegin
     *
     * @param decimal $totalRangeBegin
     * @return Coupon
     */
    public function setTotalRangeBegin($totalRangeBegin)
    {
        $this->totalRangeBegin = $totalRangeBegin;
        return $this;
    }

    /**
     * Get totalRangeBegin
     *
     * @return decimal 
     */
    public function getTotalRangeBegin()
    {
        return $this->totalRangeBegin;
    }

    /**
     * Set totalRangeEnd
     *
     * @param decimal $totalRangeEnd
     * @return Coupon
     */
    public function setTotalRangeEnd($totalRangeEnd)
    {
        $this->totalRangeEnd = $totalRangeEnd;
        return $this;
    }

    /**
     * Get totalRangeEnd
     *
     * @return decimal 
     */
    public function getTotalRangeEnd()
    {
        return $this->totalRangeEnd;
    }

    /**
     * Set usesLimit
     *
     * @param integer $usesLimit
     * @return Coupon
     */
    public function setUsesLimit($usesLimit)
    {
        $this->usesLimit = $usesLimit;
        return $this;
    }

    /**
     * Get usesLimit
     *
     * @return integer 
     */
    public function getUsesLimit()
    {
        return $this->usesLimit;
    }

    /**
     * Set singleUse
     *
     * @param boolean $singleUse
     * @return Coupon
     */
    public function setSingleUse($singleUse)
    {
        $this->singleUse = $singleUse;
        return $this;
    }

    /**
     * Get singleUse
     *
     * @return boolean 
     */
    public function getSingleUse()
    {
        return $this->singleUse;
    }

    /**
     * Add productClasses
     *
     * @param XLite\Model\ProductClass $productClasses
     * @return Coupon
     */
    public function addProductClasses(\XLite\Model\ProductClass $productClasses)
    {
        $this->productClasses[] = $productClasses;
        return $this;
    }

    /**
     * Get productClasses
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProductClasses()
    {
        return $this->productClasses;
    }

    /**
     * Add memberships
     *
     * @param XLite\Model\Membership $memberships
     * @return Coupon
     */
    public function addMemberships(\XLite\Model\Membership $memberships)
    {
        $this->memberships[] = $memberships;
        return $this;
    }

    /**
     * Get memberships
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * Add usedCoupons
     *
     * @param XLite\Module\CDev\Coupons\Model\UsedCoupon $usedCoupons
     * @return Coupon
     */
    public function addUsedCoupons(\XLite\Module\CDev\Coupons\Model\UsedCoupon $usedCoupons)
    {
        $this->usedCoupons[] = $usedCoupons;
        return $this;
    }

    /**
     * Get usedCoupons
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsedCoupons()
    {
        return $this->usedCoupons;
    }

    /**
     * Add categories
     *
     * @param XLite\Model\Category $categories
     * @return Coupon
     */
    public function addCategories(\XLite\Model\Category $categories)
    {
        $this->categories[] = $categories;
        return $this;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}