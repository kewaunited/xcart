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

namespace XLite\Module\XC\FreeShipping\Core;

/**
 * Class to collect labels for displaying in items list
 */
class Labels extends \XLite\Base\Singleton
{
    /**
     * Runtime labels cache
     *
     * @var array
     */
    protected static $labels = array();

    /**
     * Add label
     *
     * @param \XLite\Model\Product $product Product object
     * @param array                $label   Label
     *
     * @return void
     */
    public static function addLabel(\XLite\Model\Product $product, $label)
    {
        static::$labels[$product->getProductId()] = $label;
    }

    /**
     * Get registered label for product
     *
     * @param \XLite\Model\Product $product Product object
     *
     * @return array
     */
    public static function getLabel(\XLite\Model\Product $product)
    {
        if (!isset(static::$labels[$product->getProductId()])) {
            static::$labels[$product->getProductId()] = $product->getFreeShip()
                ? static::getLabelContent()
                : '';
        }

        return !empty(static::$labels[$product->getProductId()])
            ? static::$labels[$product->getProductId()]
            : array();
    }

    /**
     * Get content of Free shipping label
     *
     * @return array
     */
    protected static function getLabelContent()
    {
        return array(
            'blue free-shipping' => \XLite\Core\Translation::getInstance()->translate('FREE'),
        );
    }
}