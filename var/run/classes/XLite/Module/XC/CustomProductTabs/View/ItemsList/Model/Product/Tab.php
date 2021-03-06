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

namespace XLite\Module\XC\CustomProductTabs\View\ItemsList\Model\Product;

/**
 * Product tabs items list
 */
class Tab extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'name' => array(
                static::COLUMN_NAME          => \XLite\Core\Translation::lbl('Name'),
                static::COLUMN_TEMPLATE      => 'modules/XC/CustomProductTabs/product/name.tpl',
            ),
        );
    }

    /**
     * Get edit entity URL
     *
     * @return integer
     */
    protected function getEditURL(\XLite\Module\XC\CustomProductTabs\Model\Product\Tab $entity)
    {
        return \XLite\Core\Converter::buildUrl(
            'product',
            null,
            array(
                'product_id' => \XLite\Core\Request::getInstance()->product_id,
                'page'       => 'tabs',
                'tab_id'     => $entity->getId(),
            )
        );
    }

    /**
     * Get tab name
     *
     * @return string
     */
    protected function getTabName(\XLite\Module\XC\CustomProductTabs\Model\Product\Tab $entity)
    {
        return $entity->GetName();
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\CustomProductTabs\Model\Product\Tab';
    }


    /**
     * Creation button position
     *
     * @return integer
     */
    protected function isCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    /**
     * Get create entity URL
     *
     * @return string
     */
    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildUrl(
            'product',
            '',
            array(
                'page'       => 'tabs',
                'tab_id'     => 0,
                'product_id' => \XLite\Core\Request::getInstance()->product_id
            )
        );
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'New tab';
    }


        // {{{ Behaviors

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
     * Mark list as switchyabvle (enable / disable)
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        return true;
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
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' product_tabs';
    }

    /**
     * Get panel class
     *
     * @return \XLite\View\Base\FormStickyPanel
     */
    protected function getPanelClass()
    {
        return 'XLite\Module\XC\CustomProductTabs\View\StickyPanel\ItemsList\Product\Tab';
    }


    // {{{ Search

    /**
     * Return search parameters.
     *
     * @return array
     */
    static public function getSearchParams()
    {
        return array(
        );
    }

    /**
     * Return params list to use for search
     * TODO refactor
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();


        foreach (static::getSearchParams() as $modelParam => $requestParam) {
            $paramValue = $this->getParam($requestParam);

            if ('' !== $paramValue && 0 !== $paramValue) {
                $result->$modelParam = $paramValue;
            }
        }

        $result->product = $this->getProduct();

        return $result;
    }

    // }}}

}
