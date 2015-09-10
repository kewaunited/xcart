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

namespace XLite\View\Menu\Admin;

/**
 * Abstract admin menu
 */
abstract class AAdmin extends \XLite\View\Menu\AMenu
{
    /**
     * Item parameter names
     */
    const ITEM_TITLE         = 'title';
    const ITEM_TOOLTIP       = 'tooltip';
    const ITEM_LINK          = 'link';
    const ITEM_BLOCK         = 'block';
    const ITEM_LIST          = 'list';
    const ITEM_CLASS         = 'className';
    const ITEM_TARGET        = 'linkTarget';
    const ITEM_EXTRA         = 'extra';
    const ITEM_PERMISSION    = 'permission';
    const ITEM_PUBLIC_ACCESS = 'publicAccess';
    const ITEM_CHILDREN      = 'children';
    const ITEM_WEIGHT        = 'weight';
    const ITEM_WIDGET        = 'widget';
    const ITEM_BLANK_PAGE    = 'blankPage';
    const ITEM_ICON_FONT     = 'iconFont';
    const ITEM_ICON_SVG      = 'iconSVG';
    const ITEM_ICON_HTML     = 'iconHTML';
    const ITEM_ICON_IMG      = 'iconIMG';
    const ITEM_LABEL         = 'label';
    const ITEM_LABEL_LINK    = 'labelLink';
    const ITEM_LABEL_TITLE   = 'labelTitle';

    /**
     * Array of targets related to the same menu link
     *
     * @var array
     */
    protected $relatedTargets = array(
        'orders_stats' => array(
            'top_sellers',
        ),
        'order_list' => array(
            'order',
        ),
        'payment_transactions' => array(
            'payment_transaction',
        ),
        'product_list' => array(
            'product',
        ),
        'categories' => array(
            'category',
            'category_products',
        ),
        'profile_list' => array(
            'profile',
            'address_book',
        ),
        'shipping_methods' => array(
            'shipping_rates',
        ),
        'countries' => array(
            'zones',
            'states',
        ),
        'payment_settings' => array(
            'payment_method',
            'payment_appearance',
        ),
        'db_backup' => array(
            'db_restore',
        ),
        'product_classes' => array(
            'product_class',
            'attributes',
        ),
        'tax_classes' => array(
            'tax_class',
        ),
        'units_formats' => array(
            'currency',
        ),
        'languages' => array(
            'labels',
        ),
        'general_settings' => array(
            'shipping_settings',
            'address_fields',
        ),
        'layout' => array(
            'css_js_performance',
            'images',
        ),
        'notifications' => array(
            'notification',
            'notification_common',
        ),
    );

    /**
     * Selected item
     *
     * @var array
     */
    protected $selectedItem = array();

    /**
     * Return widget directory
     *
     * @return string
     */
    abstract protected function getDir();

    /**
     * Get default widget
     *
     * @return string
     */
    abstract protected function getDefaultWidget();

    /**
     * Returns the list of related targets
     *
     * @param string $target Target name
     *
     * @return array
     */
    public function getRelatedTargets($target)
    {
        return isset($this->relatedTargets[$target])
            ? array_merge(array($target), $this->relatedTargets[$target])
            : array($target);
    }

    /**
     * Sort items
     *
     * @param array $item1 Item 1
     * @param array $item2 Item 2
     *
     * @return boolean
     */
    protected function sortItems($item1, $item2)
    {
        return isset($item1[static::ITEM_WEIGHT])
            && isset($item2[static::ITEM_WEIGHT])
            && $item1[static::ITEM_WEIGHT] > $item2[static::ITEM_WEIGHT];
    }

    /**
     * Mark selected
     *
     * @param array $items Items
     *
     * @return array
     */
    protected function markSelected($items)
    {
        if (!empty($this->selectedItem)
            && $items
        ) {
            foreach ($items as $index => $item) {
                if ($index == $this->selectedItem['index']) {
                    $item->setWidgetParams(
                        array(
                            \XLite\View\Menu\Admin\LeftMenu\Node::PARAM_SELECTED => true
                        )
                    );
                    break;

                } elseif ($item->getParam(static::ITEM_CHILDREN)) {
                    $items[$index]->setWidgetParams(
                        array(
                            static::ITEM_CHILDREN => $this->markSelected($item->getParam(static::ITEM_CHILDREN))
                        )
                    );

                    $result = false;
                    foreach ($item->getParam(static::ITEM_CHILDREN) as $child) {
                        if ($child->getParam(\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_SELECTED)
                            || $child->getParam(\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_EXPANDED)
                        ) {
                            $result = true;
                            break;
                        }
                        
                    }

                    if ($result) {
                        $item->setWidgetParams(
                            array(
                                \XLite\View\Menu\Admin\LeftMenu\Node::PARAM_EXPANDED => true,
                            )
                        );
                    }
                }
            }
        }

        return $items;
    }

    /**
     * Prepare items
     *
     * @param array $items Items
     *
     * @return array
     */
    protected function prepareItems($items)
    {
        uasort($items, array($this, 'sortItems'));
        foreach ($items as $index => $item) {
            if (isset($item[static::ITEM_CHILDREN])
                && is_array($item[static::ITEM_CHILDREN])
                && !empty($item[static::ITEM_CHILDREN])
            ) {
                $item[static::ITEM_CHILDREN] = $this->prepareItems($item[static::ITEM_CHILDREN]);
                $item[\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_LIST] = $index;

            } elseif (isset($item[static::ITEM_CHILDREN])) {
                $item[static::ITEM_CHILDREN] = array();
            }

            $item[\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_TITLE] = empty($item[static::ITEM_TITLE])
                ? ''
                // : static::t($item[static::ITEM_TITLE]);
                : $item[static::ITEM_TITLE];
            $item[\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_TOOLTIP] = empty($item[static::ITEM_TOOLTIP])
                ? ''
                // : static::t($item[static::ITEM_TOOLTIP]);
                : $item[static::ITEM_TOOLTIP];

            if (empty($item[\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_CLASS]) && is_string($index)) {
                $item[\XLite\View\Menu\Admin\LeftMenu\Node::PARAM_CLASS] = str_replace('_', '-', $index);
            }

            if (isset($item[static::ITEM_TARGET])
                && in_array($this->getTarget(), $this->getRelatedTargets($item[static::ITEM_TARGET]))
            ) {
                $selected = true;
                $weight = 1;

                if (isset($item[static::ITEM_EXTRA])
                    && $item[static::ITEM_EXTRA]
                    && is_array($item[static::ITEM_EXTRA])
                ) {
                    foreach ($item[static::ITEM_EXTRA] as $k => $v) {
                        if (\XLite\Core\Request::getInstance()->$k == $v) {
                            $weight++;
                        } else {
                            $selected = false;
                            break;
                        }
                    }
                }

                if ($selected
                    && (empty($this->selectedItem)
                        || $weight > $this->selectedItem['weight']
                    )
                ) {
                    $this->selectedItem = array(
                        'weight' => $weight,
                        'index'  => $index,
                    );
                }
            }

            $items[$index] = $this->getWidget(
                $item,
                isset($item[static::ITEM_WIDGET]) ? $item[static::ITEM_WIDGET] : $this->getDefaultWidget()
            );

            if (!$items[$index]->checkACL()
                || !$items[$index]->isVisible()
            ) {
                unset($items[$index]);
            }
        }

        return $items;
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return \XLite\Core\Auth::getInstance()->isAdmin()
            && parent::isVisible();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/body.tpl';
    }
}
