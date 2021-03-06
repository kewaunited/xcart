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
 * Wholesale prices items list
 */
class WholesalePrices extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/Wholesale/pricing/style.css';

        return $list;
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'quantityRangeBegin' => array(
                static::COLUMN_NAME         => \XLite\Core\Translation::lbl('Quantity range'),
                static::COLUMN_CLASS        => 'XLite\Module\CDev\Wholesale\View\FormField\QuantityRangeBegin',
                static::COLUMN_ORDERBY  => 100,
            ),
            'price' => array(
                static::COLUMN_NAME         => \XLite\Core\Translation::lbl('Price'),
                static::COLUMN_CLASS        => 'XLite\Module\CDev\Wholesale\View\FormField\Price',
                static::COLUMN_ORDERBY  => 200,
            ),
            'membership' => array(
                static::COLUMN_NAME         => \XLite\Core\Translation::lbl('Membership'),
                static::COLUMN_CLASS        => 'XLite\Module\CDev\Wholesale\View\FormField\Membership',
                static::COLUMN_ORDERBY  => 300,
            ),
        );
    }

    /**
     * getRightActions
     *
     * @return array
     */
    protected function getRightActions()
    {
        $list = parent::getRightActions();

        foreach ($list as $k => $v) {
            if ('items_list/model/table/parts/remove.tpl' == $v) {
                $list[$k] = 'modules/CDev/Wholesale/pricing/parts/remove.tpl';
            }
        }

        return $list;
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\CDev\Wholesale\Model\WholesalePrice';
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return 'XLite\View\Pager\Admin\Model\Infinity';
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'New tier';
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isDisplayWithEmptyList()
    {
        return true;
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        return false;
    }

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * Inline creation mechanism position
     *
     * @return integer
     */
    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    /**
     * Get list name suffixes
     *
     * @return array
     */
    protected function getListNameSuffixes()
    {
        return array('wholesalePrices');
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' wholesale-prices';
    }

    /**
     * createEntity
     *
     * @return \XLite\Model\Product
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $entity->product = $this->getProduct();

        return $entity;
    }

    /**
     * Return true if entity is removable
     *
     * @param \XLite\Module\CDev\Wholesale\Model\WholesalePrice $entity Wholesale price object
     *
     * @return boolean
     */
    protected function isRemovableEntity($entity)
    {
        return !$entity->isDefaultPrice();
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
        // Search wholesale prices to display in the items list
        $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\WholesalePrice::P_PRODUCT} = $this->getProduct();
        $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\WholesalePrice::P_ORDER_BY_MEMBERSHIP} = true;
        $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\WholesalePrice::P_ORDER_BY}
            = array('w.quantityRangeBegin', 'ASC');

        return \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')
            ->search($cnd, $countOnly);
    }

    /**
     * Return default price
     *
     * @return mixed
     */
    protected function getDefaultPrice()
    {
        $class = '\\' . $this->defineRepositoryName();
        $result = new $class;
        $result->setPrice($this->getProduct()->getBasePrice());

        return $result;
    }

    /**
     * Get page data
     *
     * @return array
     */
    protected function getPageData()
    {
        $result = parent::getPageData();

        if (\XLite\Core\Request::getInstance()->isGet()) {
            $result = array_merge(
                array($this->getDefaultPrice()),
                $result
            );
        }

        return $result;
    }

    /**
     * Check if there are any results to display in list
     *
     * @return boolean
     */
    protected function hasResults()
    {
        return true;
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
        $this->commonParams['product_id'] = \XLite\Core\Request::getInstance()->product_id;
        $this->commonParams['page'] = 'wholesale_pricing';

        return $this->commonParams;
    }

    /**
     * Define request data
     * Remove duplicate by quantity and membership entities
     *
     * @return array
     */
    protected function defineRequestData()
    {
        $requestData = parent::defineRequestData();

        $delete = isset($requestData['delete']) ? $requestData['delete'] : array();
        $new = isset($requestData['new']) ? $requestData['new'] : array();
        $data = isset($requestData['data']) ? $requestData['data'] : array();

        foreach ($new as $id => $value) {
            $tier = $this->getTierByQuantityAndMembership($value['quantityRangeBegin'], $value['membership']);

            if (
                $tier
                && !isset($delete[$tier->getId()])
                && 0 > $id
            ) {
                $data[$tier->getId()] = array(
                    'quantityRangeBegin' => $value['quantityRangeBegin'],
                    'price' => $value['price'],
                    'membership' => $value['membership']
                );

                unset($new[$id]);

            } elseif (0 == $id) {
                unset($new[$id]);
            }
        }

        foreach ($data as $id => $value) {
            $tier = $this->getTierByQuantityAndMembership($value['quantityRangeBegin'], $value['membership']);

            if (
                $tier
                && $tier->getId() !== $id
                && !isset($delete[$tier->getId()])
            ) {
                $data[$tier->getId()] = array(
                    'quantityRangeBegin' => $value['quantityRangeBegin'],
                    'price' => $value['price'],
                    'membership' => $value['membership']
                );

                $delete[$id] = true;
                unset($data[$id]);
            }
        }

        $requestData = array_merge(
            $requestData,
            array(
                'new'    => $new,
                'delete' => $delete,
                'data'   => $data,
            )
        );

        foreach (array('data', 'new') as $idx) {
            foreach ($requestData[$idx] as $id => $value) {
                if (empty($value['membership']) && 1 == $value['quantityRangeBegin']) {
                    unset($requestData[$idx][$id]);

                    \XLite\Core\TopMessage::addWarning(
                        'The base price can not be changed on this page.'
                    );
                }
            }
        }

        return $requestData;
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
        return \XLite\Core\Database::getRepo('\XLite\Module\CDev\Wholesale\Model\WholesalePrice')
            ->findOneBy(
                array(
                    'quantityRangeBegin' => $quantity,
                    'membership'         => $membership ?: null,
                    'product'            => $this->getProduct(),
                )
            );
    }
}
