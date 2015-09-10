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

namespace XLite\View\FormField\Inline\Select\Model\Product;

/**
 * OrderItem model inline selector
 */
class OrderItem extends \XLite\View\FormField\Inline\Select\Model\Product\ProductSelector
{
    /**
     * Save widget value in entity
     *
     * @param array $field Field data
     *
     * @return void
     */
    public function saveValueName($field)
    {
        $productId = $field['widget']->getValue();
        $productId = intval($productId);

        $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($productId);

        if ($product) {
            $this->getEntity()->setProduct($product);
            $this->getEntity()->setName($product->getName());
            $this->getEntity()->setAttributeValues($product->prepareAttributeValues());
        }
    }

    /**
     * Define form field
     *
     * @return string
     */
    protected function defineFieldClass()
    {
        return 'XLite\View\FormField\Select\Model\OrderItemSelector';
    }
}
