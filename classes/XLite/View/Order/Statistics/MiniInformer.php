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

namespace XLite\View\Order\Statistics;

/**
 * Orders summary mini informer (used on Dashboard page)
 */
class MiniInformer extends \XLite\View\Dialog
{
    /**
     * Values of period parameter
     */
    const T_DAY      = 'day';
    const T_WEEK     = 'week';
    const T_MONTH    = 'month';
    const T_YEAR     = 'year';
    const T_LIFETIME = 'lifetime';

    /**
     * Names of tab sections
     */
    const P_ORDERS  = 'orders';
    const P_REVENUE = 'revenue';

    /**
     * No statistics flag
     *
     * @var boolean
     */
    protected $emptyStats = false;

    protected $firstOrderDate = null;

    /**
     * Add widget specific CSS file
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/style.css';

        return $list;
    }

    /**
     * Add widget specific JS-file
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/controller.js';

        return $list;
    }


    /**
     * Return widget templates directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'order/statistics/informer';
    }

    /**
     * Define tabs
     *
     * @return array
     */
    protected function defineTabs()
    {
        return array(
            self::T_DAY => array(
                'name' => 'Day',
                'template' => 'order/statistics/informer/parts/day.tpl',
            ),
            self::T_WEEK => array(
                'name' => 'Week',
                'template' => 'order/statistics/informer/parts/week.tpl',
            ),
            self::T_MONTH => array(
                'name' => 'Month',
                'template' => 'order/statistics/informer/parts/month.tpl',
            ),
            self::T_YEAR => array(
                'name' => 'Year',
                'template' => 'order/statistics/informer/parts/year.tpl',
            ),
            self::T_LIFETIME => array(
                'name' => 'Lifetime',
                'template' => 'order/statistics/informer/parts/lifetime.tpl',
            ),
        );
    }

    /**
     * Process tabs
     *
     * @param array $tabs Tabs
     *
     * @return array
     */
    protected function postprocessTabs($tabs)
    {
        foreach ($tabs as $k => $tab) {
            $tabs[$k] = array_merge($tab, $this->getOrdersSummary($k));
        }

        return $tabs;
    }

    /**
     * Get orders summary statistics
     *
     * @param string $key Period name
     *
     * @return array
     */
    protected function getOrdersSummary($key)
    {
        $result = array(
            'orders' => array(
                'value' => 0,
                'prev'  => 0,
            ),
            'revenue' => array(
                'value' => 0,
                'prev'  => 0,
            ),
        );

        $now = \XLite\Core\Converter::time();

        switch ($key) {
            case self::T_DAY:
                $startDate = mktime(0, 0, 0, date('m', $now), date('d', $now), date('Y', $now));
                $prevStartDate = $startDate - 86400;
                break;

            case self::T_WEEK:
                $startDate = $now - (date('w', $now) * 86400);
                $prevStartDate = $startDate - 7 * 86400;
                break;

            case self::T_MONTH:
                $startDate = mktime(0, 0, 0, date('m', $now), 1, date('Y', $now));
                $prevStartDate = mktime(0, 0, 0, date('m', $now) - 1, 1, date('Y', $now));
                break;

            case self::T_YEAR:
                $startDate = mktime(0, 0, 0, 1, 1, date('Y', $now));
                $prevStartDate = mktime(0, 0, 0, 1, 1, date('Y', $now) - 1);
                break;

            default:
                $startDate = 0;
                $prevStartDate = 0;
        }

        $thisPeriod = \XLite\Core\Database::getRepo('XLite\Model\Order')->getOrderStats($startDate);

        $result['orders']['value'] = $thisPeriod['orders_count'];
        $result['revenue']['value'] = $thisPeriod['orders_total'];

        if (self::T_LIFETIME != $key) {
            $prevPeriod = \XLite\Core\Database::getRepo('XLite\Model\Order')
                ->getOrderStats($prevStartDate, $startDate - 1);

            $result['orders']['prev'] = $prevPeriod['orders_count'];
            $result['revenue']['prev'] = $prevPeriod['orders_total'];
            $result['startDate'] = $startDate;

        } elseif (0 == $result['orders']['value']) {
            $this->emptyStats = true;
        }

        return $result;
    }

    /**
     * Prepare tabs
     *
     * @return array
     */
    protected function getTabs()
    {
        $tabs = $this->defineTabs();
        foreach ($tabs as $k => $tab) {
            $tabs[$k]['class'] = $k;
        }

        return $this->postprocessTabs($tabs);
    }

    /**
     * Get image as a mark of delta between current value and value for previous period
     *
     * @param array $tab Tab data cell
     *
     * @return string
     */
    protected function getIcon(array $tab)
    {
        if ($tab['revenue']['prev'] == $tab['revenue']['value'] || self::T_LIFETIME == $tab['class']) {
            $icon = '';

        } elseif ($tab['revenue']['prev'] > $tab['revenue']['value']) {
            $icon = $this->getSVGImage('images/down_arrow.svg');

        } else {
            $icon = $this->getSVGImage('images/up_arrow.svg');
        }

        return $icon;
    }

    /**
     * Get class name as a mark of delta between current value and value for previous period
     *
     * @param array $tab ab data cell
     *
     * @return string
     */
    protected function getRevenueClass(array $tab)
    {
        if ($tab['revenue']['prev'] == $tab['revenue']['value'] || self::T_LIFETIME == $tab['class']) {
            $result = '';

        } elseif ($tab['revenue']['prev'] > $tab['revenue']['value']) {
            $result = 'down';

        } else {
            $result = 'up';
        }

        return $result;
    }

    /**
     * Get class name as a mark of delta between current value and value for previous period
     *
     * @param array $tab ab data cell
     *
     * @return boolean
     */
    protected function showPrevious(array $tab)
    {
        $firstOrderDate = $this->getFirstOrderDate();

        return !$firstOrderDate || $firstOrderDate < $tab['startDate'];
    }

    /**
     * Return true if no statistics
     *
     * @return boolean
     */
    protected function isEmptyStats()
    {
        return $this->emptyStats;
    }

    /**
     * Get block style
     *
     * @return string
     */
    protected function getBlockStyle()
    {
        return '';
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    protected function checkACL()
    {
        return parent::checkACL()
            && \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage orders');
    }

    /**
     * Get first order date
     *
     * @return integer
     */
    protected function getFirstOrderDate()
    {
        if (!isset($this->firstOrderDate)) {
            $this->firstOrderDate = \XLite\Core\Database::getRepo('XLite\Model\Order')->getFistOpenOrderDate();
        }

        return $this->firstOrderDate;
    }
}
