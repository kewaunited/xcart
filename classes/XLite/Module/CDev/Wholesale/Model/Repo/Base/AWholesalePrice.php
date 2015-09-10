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

namespace XLite\Module\CDev\Wholesale\Model\Repo\Base;

/**
 * WholesalePrice model repository
 */
class AWholesalePrice extends \XLite\Model\Repo\ARepo
{
    /**
     * Allowable search params
     */
    const P_MEMBERSHIP          = 'membership';
    const P_QTY                 = 'quantity';
    const P_MIN_QTY             = 'minQuantity';
    const P_ORDER_BY            = 'orderBy';
    const P_ORDER_BY_MEMBERSHIP = 'orderByMembership';
    const P_LIMIT               = 'limit';

    // {{{ Additional helper methods

    /**
     * Re-calculate quantityRangeEnd value for each price
     *
     * @param mixed $object Object
     *
     * @return void
     */
    public function correctQuantityRangeEnd($object)
    {
        $cnd = new \XLite\Core\CommonCell();
        $cnd->{self::P_ORDER_BY} = array('w.quantityRangeBegin', 'ASC');

        // Get all prices
        $allPrices = $this->search($this->processContition($cnd, $object));

        if ($allPrices) {

            // Calculate new quantityRangeEnd values for all prices...

            $membershipsHash = array();
            $maxQuantities = array();

            // Get hash of quantityRangeBegin for all prices (group by membership)
            foreach ($allPrices as $key => $price) {
                $membershipId = $price->getMembership() ? $price->getMembership()->getMembershipId() : 0;
                $membershipsHash[$membershipId][$key] = $price->getQuantityRangeBegin();
            }

            // Max allowed value for quantityRangeEnd
            $absMaxQuantity = pow(10, 16);

            // Find quantityRangeEnd for each price and store it in array $maxQuantities
            foreach ($membershipsHash as $membershipId => $membershipDiscounts) {

                foreach ($membershipDiscounts as $priceKey => $minQuantity) {

                    $maxQuantity = $absMaxQuantity;

                    foreach ($membershipDiscounts as $quantity) {
                        if ($quantity > $minQuantity && $quantity < $maxQuantity) {
                            $maxQuantity = $quantity - 1;
                        }
                    }

                    if ($maxQuantity == $absMaxQuantity) {
                        $maxQuantity = 0;
                    }

                    $maxQuantities[$priceKey] = $maxQuantity;
                }
            }

            $needUpdate = false;

            // Update quantityRangeEnd value if it differs from current value
            foreach ($allPrices as $key => $price) {
                if ($price->getQuantityRangeEnd() != $maxQuantities[$key]) {
                    $price->setQuantityRangeEnd($maxQuantities[$key]);
                    \XLite\Core\Database::getEM()->persist($price);
                    $needUpdate = true;
                }
            }

            if ($needUpdate) {
                \XLite\Core\Database::getEM()->flush();
            }
        } // if ($allPrices)
    }

    /**
     * Check if the object has any wholesale price
     *
     * @param mixed $object Object
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function hasWholesalePrice($object)
    {
        $cnd = new \XLite\Core\CommonCell();

        return 0 < count($this->search($this->processContition($cnd, $object)));
    }

    /**
     * Return price under amount and membership conditions
     *
     * @param mixed                   $object     Object
     * @param integer                 $amount     Quantity of product
     * @param \XLite\Model\Membership $membership Membership object OPTIONAL
     *
     * @return float Product variant price
     * @return null  Null price means the default value for specific price type must be used
     */
    public function getPrice($object, $amount, $membership = null)
    {

        if (
            1 == $amount
            && !$membership
        ) {
            $price = $object->getBasePrice();

        } else {
            $cnd = new \XLite\Core\CommonCell();

            $cnd->{static::P_MEMBERSHIP}          = $membership;
            $cnd->{static::P_QTY}                 = $amount;
            $cnd->{static::P_ORDER_BY}            = array('w.price', 'ASC');
            $cnd->{static::P_ORDER_BY_MEMBERSHIP} = false;

            $prices = $this->search($this->processContition($cnd, $object));

            $price = null;
            if (isset($prices[0])) {
                $price = $prices[0]->getPrice();

                // to allow batch product update in \XLite\Core\QuickData
                \XLite\Core\Database::getEM()->detach($prices[0]);
            }
        }

        return $price;
    }

    /**
     * Return wholesale prices for the given product
     *
     * @param mixed                   $object     Object
     * @param \XLite\Model\Membership $membership Membership object OPTIONAL
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getWholesalePrices($object, $membership = null)
    {
        $cnd = new \XLite\Core\CommonCell();

        $minQty = $object->getMinQuantity($membership);

        $cnd->{static::P_MEMBERSHIP} = $membership;
        $cnd->{static::P_MIN_QTY}    = $minQty;
        $cnd->{static::P_ORDER_BY}   = array('w.quantityRangeBegin', 'ASC');
        $cnd->{static::P_ORDER_BY_MEMBERSHIP} = false;

        $prices = $this->search($this->processContition($cnd, $object));

        if (empty($prices)) {
            return array();
        }

        if (1 < $minQty) {
            foreach ($prices as $key => $price) {
                if ($prices[$key]->getQuantityRangeBegin() < $minQty) {
                    $prices[$key]->setQuantityRangeBegin($minQty);
                }
            }
        }

        if (!empty($membership)) {

            $result = array();

            foreach ($prices as $key => $price) {
                if (!empty($minimalPrice)
                    && !empty($lastKey)
                    && $result[$lastKey]->getQuantityRangeBegin() < $price->getQuantityRangeBegin()) {
                    $result[$lastKey]->setQuantityRangeEnd($price->getQuantityRangeBegin() - 1);
                }

                //get all ranges for quantity point
                $rangesHaving = array();
                foreach ($prices as $rangeKey => $range) {
                    if ($price->getQuantityRangeBegin() >= $range->getQuantityRangeBegin()
                        && ($range->getQuantityRangeEnd() == 0
                            || $price->getQuantityRangeBegin() <= $range->getQuantityRangeEnd())
                        ) {
                        $rangesHaving[] = $range;
                    }
                }

                $minimalPrice = null;
                if (!empty($rangesHaving)) {
                    //get minimal price range for quantity point
                    foreach ($rangesHaving as $rangeKey => $range) {
                        if (empty($minimalPrice) || $range->getPrice() < $minimalPrice->getPrice()) {
                            $minimalPrice = $range;
                        }
                    }
                    $result[] = clone $minimalPrice;
                    end($result);
                    $lastKey = key($result);
                    reset($result);
                }
            }

            $prices = $result;
        }

        // Transform qty ranges with same price to the single range
        if (!empty($prices)) {
            $currentKey = null;

            foreach ($prices as $key => $price) {
                if (!isset($currentKey)) {
                    $currentKey = $key;

                    continue;
                }

                if ($prices[$currentKey]->getPrice() == $price->getPrice()) {
                    $prices[$currentKey]->setQuantityRangeEnd($price->getQuantityRangeEnd());
                    unset($prices[$key]);
                } else {
                    $currentKey = $key;
                }
            }
        }

        if (
            1 == count($prices)
            && isset($prices[0])
            && 1 == $prices[0]->getQuantityRangeBegin()
        ) {
            $prices = array();
        }

        return $prices;
    }

    // }}}

    // {{{ Search wholesale prices methods

    /**
     * Search for prices
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only count OPTIONAL
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    public function search(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $queryBuilder = $this->createQueryBuilder('w');
        $this->currentSearchCnd = $cnd;

        $membershipRelation = false;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);

            if (in_array($key, array(static::P_MEMBERSHIP, static::P_ORDER_BY_MEMBERSHIP))) {
                $membershipRelation = true;
            }
        }

        if ($membershipRelation) {
            $queryBuilder->leftJoin('w.membership', 'membership');
        }

        $cnd = new \Doctrine\ORM\Query\Expr\Orx();
        $cnd->add('w.quantityRangeBegin <> 1');
        $cnd->add('w.membership IS NOT NULL');
        $queryBuilder->andWhere($cnd);

        return $countOnly
            ? $this->searchCount($queryBuilder)
            : $this->searchResult($queryBuilder);
    }

    /**
     * Search count only routine.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder routine
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    protected function searchCount(\Doctrine\ORM\QueryBuilder $qb)
    {
        $qb->select('COUNT(w.id)');

        return intval($qb->getSingleScalarResult());
    }

    /**
     * Search result routine.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder routine
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    protected function searchResult(\Doctrine\ORM\QueryBuilder $qb)
    {
        return $qb->getResult();
    }

    /**
     * Return list of handling search params
     *
     * @return array
     */
    protected function getHandlingSearchParams()
    {
        return array(
            static::P_MEMBERSHIP,
            static::P_QTY,
            static::P_MIN_QTY,
            static::P_ORDER_BY,
            static::P_ORDER_BY_MEMBERSHIP,
            static::P_LIMIT,
        );
    }

    /**
     * Check if param can be used for search
     *
     * @param string $param Name of param to check
     *
     * @return boolean
     */
    protected function isSearchParamHasHandler($param)
    {
        return in_array($param, $this->getHandlingSearchParams());
    }

    /**
     * Call corresponded method to handle a search condition
     *
     * @param mixed                      $value        Condition data
     * @param string                     $key          Condition name
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param boolean                    $countOnly    Return items list or only count OPTIONAL
     *
     * @return void
     */
    protected function callSearchConditionHandler($value, $key, \Doctrine\ORM\QueryBuilder $queryBuilder, $countOnly)
    {
        if ($this->isSearchParamHasHandler($key)) {
            $this->{'prepareCnd' . ucfirst($key)}($queryBuilder, $value, $countOnly);
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndMembership(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if (!empty($value)) {

            if (is_object($value)) {
                $value = $value->getMembershipId();
            }

            $cnd = new \Doctrine\ORM\Query\Expr\Orx();
            $cnd->add('membership.membership_id = :membershipId');
            $cnd->add('w.membership IS NULL');

            $queryBuilder->andWhere($cnd)
                ->setParameter('membershipId', $value);

        } else {
            $queryBuilder->andWhere('w.membership IS NULL');
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndQuantity(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $cnd = new \Doctrine\ORM\Query\Expr\Orx();
        $cnd->add('w.quantityRangeEnd >= :qty');
        $cnd->add('w.quantityRangeEnd = 0');

        $queryBuilder->andWhere('w.quantityRangeBegin <= :qty')
            ->andWhere($cnd)
            ->setParameter('qty', $value);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndMinQuantity(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $cnd = new \Doctrine\ORM\Query\Expr\Orx();
        $cnd->add('w.quantityRangeEnd >= :minQty');
        $cnd->add('w.quantityRangeEnd = 0');

        $queryBuilder->andWhere($cnd)
            ->setParameter('minQty', $value);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndOrderBy(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value, $countOnly)
    {
        if (!$countOnly) {
            list($sort, $order) = $value;

            $queryBuilder->addOrderBy($sort, $order);
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndOrderByMembership(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $this->prepareCndOrderBy($queryBuilder, array('membership.membership_id', $value ? 'ASC' : 'DESC'), $countOnly);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndLimit(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value)
    {
        $queryBuilder->setFrameResults($value);
    }

    // }}}
}