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

namespace XLite\Module\CDev\Wholesale\View\ItemsList;

/**
 * Wholesale prices items list (product variant)
 *
 * @LC_Dependencies("XC\ProductVariants")
 */
class ProductVariantWholesalePrices extends \XLite\Module\CDev\Wholesale\View\ItemsList\WholesalePrices implements \XLite\Base\IDecorator
{
    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'product_variant' == $this->getTarget()
            ? 'XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice'
            : parent::defineRepositoryName();
    }

    /**
     * createEntity
     *
     * @return \XLite\Module\XC\ProductVariants\Model\ProductVariant
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();
        if ('product_variant' == $this->getTarget()) {
            $entity->productVariant = $this->getProductVariant();
        }

        return $entity;
    }

    // {{{ Data

    /**
     * Return wholesale prices
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        if ('product_variant' == $this->getTarget()) {
            $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\ProductVariantWholesalePrice::P_PRODUCT_VARIANT} = $this->getProductVariant();
            $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\ProductVariantWholesalePrice::P_ORDER_BY_MEMBERSHIP} = true;
            $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\ProductVariantWholesalePrice::P_ORDER_BY} = array('w.quantityRangeBegin', 'ASC');

             $result = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')
                ->search($cnd, $countOnly);

        } else {
            $result = parent::getData($cnd, $countOnly);
        }

        return $result;
    }

    /**
     * Return default price
     *
     * @return mixed
     */
    protected function getDefaultPrice()
    {
        $result = parent::getDefaultPrice();
        if ('product_variant' == $this->getTarget()) {
            $result->setPrice($this->getProductVariant()->getClearPrice());
        }

        return $result;
    }

    // }}}

    /**
     * Get URL common parameters
     *
     * @return array
     */
    protected function getCommonParams()
    {
        $this->commonParams = parent::getCommonParams();
        $this->commonParams['id'] = \XLite\Core\Request::getInstance()->id;

        return $this->commonParams;
    }

    /**
     * Get tier by quantity and membership
     *
     * @param integer $quantity   Quantity
     * @param integer $membership Membership
     *
     * @return \XLite\Module\CDev\Wholesale\Model\WholesalePrice
     */
    protected function getTierByQuantityAndMembership($quantity, $membership)
    {
        return 'product_variant' == $this->getTarget()
            ? \XLite\Core\Database::getRepo('\XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')
                ->findOneBy(
                    array(
                        'quantityRangeBegin' => $quantity,
                        'membership'         => $membership ?: null,
                        'productVariant'     => $this->getProductVariant(),
                    )
                )
            : parent::getTierByQuantityAndMembership($quantity, $membership);
    }
}
