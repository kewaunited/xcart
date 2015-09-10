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

namespace XLite\Module\XC\Reviews\Model;

/**
 * The "review" model class
 *
 * @Entity (repositoryClass="\XLite\Module\XC\Reviews\Model\Repo\Review")
 * @Table  (name="reviews",
 *      indexes={
 *          @Index (name="additionDate", columns={"additionDate"}),
 *          @Index (name="status", columns={"status"}),
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class Review extends \XLite\Model\AEntity
{
    const STATUS_APPROVED               = 1;
    const STATUS_PENDING                = 0;
    const MAX_RATING                    = 5;
    const ALL_CUSTOMERS                 = 'A';
    const REGISTERED_CUSTOMERS          = 'R';
    const PURCHASED_CUSTOMERS           = 'P';
    const TTL_LIMIT_FOR_REVIEW_FROM_IP  = 1800;

    /**
     * Review Unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Review text
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $review = '';

    /**
     * Review rating
     *
     * @var integer
     *
     * @Column (type="smallint")
     */
    protected $rating = self::MAX_RATING;

    /**
     * Addition date (UNIX timestamp)
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $additionDate;

    /**
     * Relation to a profile entity (who adds review)
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile", inversedBy="reviews")
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $profile;

    /**
     * Reviewer name
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $reviewerName = '';

    /**
     * Reviewer email
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $email = '';

    /**
     * Review status
     *
     * @var integer
     *
     * @Column (type="smallint")
     */
    protected $status = self::STATUS_PENDING;

    /**
     * Relation to a product entity
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToOne  (targetEntity="XLite\Model\Product", inversedBy="reviews")
     * @JoinColumn (name="product_id", referencedColumnName="product_id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * Remote ip2long
     *
     * @var integer
     *
     * @Column (type="bigint")
     */
    protected $ip = 0;

    /**
     * Use for meta flag
     *
     * @var boolean
     *
     * @Column(type="boolean")
     */
    protected $useForMeta = false;

    /**
     * Define if review is new
     *
     * @return boolean
     */
    public function isNew()
    {
        return !$this->isPersistent();
    }

    /**
     * Define if review is approved
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->getStatus() == static::STATUS_APPROVED;
    }

    /**
     * Define if review is not approved
     *
     * @return boolean
     */
    public function isNotApproved()
    {
        return !$this->isApproved() && !$this->isNew();
    }

    /**
     * Prepare creation date
     *
     * @return void
     *
     * @PrePersist
     */
    public function prepareBeforeCreate()
    {
        if (!$this->getAdditionDate()) {
            $this->setAdditionDate(\XLite\Core\Converter::time());
        }
    }

    /**
     * Returns meta description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        $data = array(
            'rating'       => $this->getProduct()->getAverageRating(),
            'maxRating'    => static::MAX_RATING,
            'reviewerName' => $this->getReviewerName(),
            'review'       => $this->getReview(),
        );

        return \XLite::t('reviewMetaDescription', $data);
    }

    /**
     * Returns code for useForMeta selector
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->getId();
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return \XLite\Module\XC\Reviews\Model\Review
     */
    public function setRating($rating)
    {
        $this->rating = max(min($rating, static::MAX_RATING), 1);

        return $this;
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
     * Set review
     *
     * @param text $review
     * @return Review
     */
    public function setReview($review)
    {
        $this->review = $review;
        return $this;
    }

    /**
     * Get review
     *
     * @return text 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Get rating
     *
     * @return smallint 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set additionDate
     *
     * @param integer $additionDate
     * @return Review
     */
    public function setAdditionDate($additionDate)
    {
        $this->additionDate = $additionDate;
        return $this;
    }

    /**
     * Get additionDate
     *
     * @return integer 
     */
    public function getAdditionDate()
    {
        return $this->additionDate;
    }

    /**
     * Set reviewerName
     *
     * @param string $reviewerName
     * @return Review
     */
    public function setReviewerName($reviewerName)
    {
        $this->reviewerName = $reviewerName;
        return $this;
    }

    /**
     * Get reviewerName
     *
     * @return string 
     */
    public function getReviewerName()
    {
        return $this->reviewerName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Review
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param smallint $status
     * @return Review
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return smallint 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ip
     *
     * @param bigint $ip
     * @return Review
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get ip
     *
     * @return bigint 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set useForMeta
     *
     * @param boolean $useForMeta
     * @return Review
     */
    public function setUseForMeta($useForMeta)
    {
        $this->useForMeta = $useForMeta;
        return $this;
    }

    /**
     * Get useForMeta
     *
     * @return boolean 
     */
    public function getUseForMeta()
    {
        return $this->useForMeta;
    }

    /**
     * Set profile
     *
     * @param XLite\Model\Profile $profile
     * @return Review
     */
    public function setProfile(\XLite\Model\Profile $profile = null)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return XLite\Model\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set product
     *
     * @param XLite\Model\Product $product
     * @return Review
     */
    public function setProduct(\XLite\Model\Product $product = null)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get product
     *
     * @return XLite\Model\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}