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

namespace XLite\Module\XC\ProductFilter\View\Model;

/**
 * Decorate product settings page
 */
class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Update product categories
     *
     * @param \XLite\Model\Product $model       Product model
     * @param array                $categoryIds List of IDs of new categories
     *
     * @return void
     */
    protected function updateProductCategories($model, $categoryIds)
    {
        $categoriesToRemoveCache = array();

        // List of old category IDs
        $oldCategoryIds = array();

        // Get old category IDs list
        $oldCategoryProducts = $model->getCategoryProducts()->toArray();

        if (!empty($oldCategoryProducts)) {

            foreach ($oldCategoryProducts as $cp) {
                $oldCategoryIds[] = $cp->getCategory()->getCategoryId();

                if (!in_array($cp->getCategory()->getCategoryId(), $categoryIds)) {
                    $categoriesToRemoveCache[] = $cp->getCategory()->getCategoryId();
                }
            }

        }

        $categoriesToRemoveCache = array_merge(
            $categoriesToRemoveCache,
            array_diff($categoryIds, $oldCategoryIds)
        );

        if ($categoriesToRemoveCache) {
            \XLite\Core\Database::getRepo('XLite\Model\Category')->removeProductFilterCache(
                $categoriesToRemoveCache
            );
        }

        parent::updateProductCategories($model, $categoryIds);
    }
}
