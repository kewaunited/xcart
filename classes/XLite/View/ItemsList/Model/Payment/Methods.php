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

namespace XLite\View\ItemsList\Model\Payment;

/**
 * Methods items list
 */
class Methods extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'title' => array(
                static::COLUMN_NAME      => static::t('Title'),
                static::COLUMN_CLASS     => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_TEMPLATE  => 'items_list/model/table/payment/cell.name.tpl',
                static::COLUMN_PARAMS    => array('required' => true),
                static::COLUMN_ORDERBY   => 200,
                static::COLUMN_EDIT_ONLY => true,
            ),
            'description' => array(
                static::COLUMN_NAME    => static::t('Description'),
                static::COLUMN_CLASS   => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_PARAMS  => array('required' => false),
                static::COLUMN_ORDERBY  => 300,
                static::COLUMN_EDIT_ONLY => true,
            ),
        );
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Payment\Method';
    }

    // {{{ Behaviors

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return false;
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
     * Mark list as sortable
     *
     * @return integer
     */
    protected function getSortableType()
    {
        return static::SORT_TYPE_MOVE;
    }

    // }}}

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        return $column[static::COLUMN_CODE] === 'title' || parent::isClassColumnVisible($column, $entity);
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' payment-methods';
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $result->{\XLite\Model\Repo\Payment\Method::P_MODULE_ENABLED} = true;
        $result->{\XLite\Model\Repo\Payment\Method::P_ADDED} = true;
        $result->{\XLite\Model\Repo\Payment\Method::P_POSITION} = array(
            \XLite\Model\Repo\Payment\Method::FIELD_DEFAULT_POSITION,
            static::SORT_ORDER_ASC,
        );

        return $result;
    }

    /**
     * Return "empty list" catalog
     *
     * @return string
     */
    protected function getEmptyListDir()
    {
        return parent::getEmptyListDir() . '/payment/appearance';
    }

    /**
     * Define line class as list of names
     *
     * @param integer              $index  Line index
     * @param \XLite\Model\AEntity $entity Line model OPTIONAL
     *
     * @return array
     */
    protected function defineLineClass($index, \XLite\Model\AEntity $entity = null)
    {
        $result = parent::defineLineClass($index, $entity);

        if (!$entity->getEnabled()) {
            $result[] = 'disabled-method';
        }

        return $result;
    }

    /**
     * Get hint text for entity status
     *
     * @param \XLite\Model\AEntity $entity Line model
     *
     * @return string
     */
    protected function getMethodStatusTitle(\XLite\Model\AEntity $entity)
    {
        return $entity->getEnabled()
            ? static::t('Payment method is enabled')
            : static::t('Payment method is disabled');
    }
}
