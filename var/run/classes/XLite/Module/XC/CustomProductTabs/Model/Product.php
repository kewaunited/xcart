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

namespace XLite\Module\XC\CustomProductTabs\Model;

/**
 * The "Product" decoration model class
 * @MappedSuperClass
 */
abstract class Product extends \XLite\Module\XC\AuctionInc\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Order tabs
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OrderBy   ({"position" = "ASC"})
     * @OneToMany (targetEntity="XLite\Module\XC\CustomProductTabs\Model\Product\Tab", mappedBy="product", cascade={"all"})
     */
    protected $tabs;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->tabs = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Clone product
     *
     * @return \XLite\Model\AEntity
     */
    public function cloneEntity()
    {
        $newProduct = parent::cloneEntity();

        if ($this->getTabs()) {
            foreach ($this->getTabs() as $tab) {
                $newTab = $tab->cloneEntity();
                $newTab->setProduct($newProduct);
                $newProduct->addTabs($newTab);

                \XLite\Core\Database::getEM()->persist($newTab);
            }
        }

        return $newProduct;
    }

    /**
     * Add tabs
     *
     * @param XLite\Module\XC\CustomProductTabs\Model\Product\Tab $tabs
     * @return Product
     */
    public function addTabs(\XLite\Module\XC\CustomProductTabs\Model\Product\Tab $tabs)
    {
        $this->tabs[] = $tabs;
        return $this;
    }

    /**
     * Get tabs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTabs()
    {
        return $this->tabs;
    }
}