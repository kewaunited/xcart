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

namespace XLite\Model\Repo;

/**
 * Region repository
 */
class Region extends \XLite\Model\Repo\ARepo
{
    /**
     * Find all regions
     *
     * @return array
     */
    public function findAllRegions()
    {
        $data = $this->getFromCache('all');

        if (!isset($data)) {
            $data = $this->defineAllRegionsQuery()->getResult();
            $this->saveToCache($data, 'all');
        }

        return $data;
    }

    /**
     * Find regions by country code
     *
     * @param string $countryCode Country code
     *
     * @return \XLite\Model\State|void
     */
    public function findByCountryCode($countryCode)
    {
        $country = \XLite\Core\Database::getRepo('XLite\Model\Country')->find($countryCode);

        return $country ? $this->defineByCountryQuery($country)->getResult() : array();
    }

    /**
     * Find region by code 
     *
     * @param string $code     Region code
     *
     * @return \XLite\Model\Region
     */
    public function findByCode($code)
    {
        return $this->defineOneByCodeQuery($code)->getSingleResult();
    }

    /**
     * Define query builder for findAllRegions()
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineAllRegionsQuery()
    {
        return $this->createQueryBuilder()
            ->addSelect('c')
            ->leftJoin('r.country', 'c');
    }

    /**
     * Define query for findByCountryCode() method
     *
     * @param \XLite\Model\Country $country Country
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineByCountryQuery(\XLite\Model\Country $country)
    {
        return $this->createQueryBuilder()
            ->andWhere('r.country = :country')
            ->setParameter('country', $country);
    }

    /**
     * Define query builder for findOneByCode()
     *
     * @param string $code Region Code
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineOneByCodeQuery($code)
    {
        return $this->createQueryBuilder()
            ->addSelect('c')
            ->leftJoin('r.country', 'c')
            ->andWhere('r.code = :code')
            ->setParameter('code', $code)
            ->setMaxResults(1);
    }

    // {{{ Cache

    /**
     * Define cache cells
     *
     * @return array
     */
    protected function defineCacheCells()
    {
        $list = parent::defineCacheCells();

        $list['all'] = array(
            self::RELATION_CACHE_CELL => array('\XLite\Model\Country'),
        );

        $list['codes'] = array(
            self::ATTRS_CACHE_CELL => array('code'),
        );

        return $list;
    }

    // }}}
}
