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

namespace XLite\View\ItemsList\Model;

/**
 * Notifications items list
 */
class Notification extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Returns CSS Files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'notifications/style.css';

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
            'name' => array(
                static::COLUMN_NAME    => static::t('Name'),
                static::COLUMN_MAIN    => true,
                static::COLUMN_LINK    => 'notification',
                static::COLUMN_ORDERBY => 100,
            ),
            'enabledForAdmin' => array(
                static::COLUMN_NAME    => static::t('Administrator'),
                static::COLUMN_CLASS   => 'XLite\View\FormField\Inline\Input\Checkbox\Switcher\NotificationStatus',
                static::COLUMN_ORDERBY => 200,
            ),
            'enabledForCustomer' => array(
                static::COLUMN_NAME    => static::t('Customer'),
                static::COLUMN_CLASS   => 'XLite\View\FormField\Inline\Input\Checkbox\Switcher\NotificationStatus',
                static::COLUMN_ORDERBY => 300,
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
        return 'XLite\Model\Notification';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' notifications';
    }

    /**
     * Check if the column template is used for widget displaying
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isTemplateColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isTemplateColumnVisible($column, $entity);

        switch ($column[static::COLUMN_CODE]) {
            case 'enabledForAdmin':
                $result = $result && ($entity->getAvailableForAdmin() || $entity->getEnabledForAdmin());
                break;

            case 'enabledForCustomer':
                $result = $result && ($entity->getAvailableForCustomer() || $entity->getEnabledForCustomer());
                break;

            default:
                break;
        }

        return $result;
    }

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isClassColumnVisible($column, $entity);

        switch ($column[static::COLUMN_CODE]) {
            case 'enabledForAdmin':
                $result = $result && ($entity->getAvailableForAdmin() || $entity->getEnabledForAdmin());
                break;

            case 'enabledForCustomer':
                $result = $result && ($entity->getAvailableForCustomer() || $entity->getEnabledForCustomer());
                break;

            default:
                break;
        }

        return $result;
    }
}