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

namespace XLite\Model;

/**
 * @MappedSuperClass (repositoryClass="\XLite\Model\Repo\CleanURL")
 */
abstract class CleanURLAbstract extends \XLite\Model\AEntity
{
    /**
     * Unique id
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={"unsigned": true })
     */
    protected $id;

    /**
     * Relation to a product entity
     *
     * @var \XLite\Model\Product
     *
     * @ManyToOne  (targetEntity="XLite\Model\Product", inversedBy="cleanURLs")
     * @JoinColumn (name="product_id", referencedColumnName="product_id")
     */
    protected $product;

    /**
     * Relation to a category entity
     *
     * @var \XLite\Model\Category
     *
     * @ManyToOne  (targetEntity="XLite\Model\Category", inversedBy="cleanURLs")
     * @JoinColumn (name="category_id", referencedColumnName="category_id")
     */
    protected $category;

    /**
     * Clean URL
     *
     * @var string
     *
     * @Column (type="string", length=255, nullable=true)
     */
    protected $cleanURL;

    /**
     * Set entity
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return void
     */
    public function setEntity($entity)
    {
        $entityType = \XLite\Model\Repo\CleanURL::getEntityType($entity);

        $method = 'set' . \XLite\Core\Converter::convertToCamelCase($entityType);
        if (method_exists($this, $method)) {
            $this->{$method}($entity);
        }
    }

    /**
     * Get entity
     *
     * @return \XLite\Model\AEntity
     */
    public function getEntity()
    {
        $entity = null;

        foreach (\XLite\Model\Repo\CleanURL::getEntityTypes() as $type) {
            $method = 'get' . \XLite\Core\Converter::convertToCamelCase($type);
            if (method_exists($this, $method)) {
                $entity = $this->{$method}();

                if ($entity) {
                    break;
                }
            }
        }

        return $entity;
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
     * Set cleanURL
     *
     * @param string $cleanURL
     * @return CleanURL
     */
    public function setCleanURL($cleanURL)
    {
        $this->cleanURL = $cleanURL;
        return $this;
    }

    /**
     * Get cleanURL
     *
     * @return string 
     */
    public function getCleanURL()
    {
        return $this->cleanURL;
    }

    /**
     * Set product
     *
     * @param XLite\Model\Product $product
     * @return CleanURL
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

    /**
     * Set category
     *
     * @param XLite\Model\Category $category
     * @return CleanURL
     */
    public function setCategory(\XLite\Model\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return XLite\Model\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}