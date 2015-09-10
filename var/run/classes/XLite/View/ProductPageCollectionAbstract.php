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

namespace XLite\View;

/**
 * Product page widgets collection
 */
abstract class ProductPageCollectionAbstract extends \XLite\View\AWidgetsCollection
{

    /**
     * Widget parameters
     */
    const PARAM_PRODUCT = 'product';


    /**
     * Product modifier types
     *
     * @var array
     */
    protected $productModifierTypes;

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_PRODUCT => new \XLite\Model\WidgetParam\Object('Product', $this->getDefaultProduct(), false, '\XLite\Model\Product'),
        );
    }

    /**
     * Register the view classes collection
     *
     * @return array
     */
    protected function defineWidgetsCollection()
    {
        return array(
            '\XLite\View\Price',
            '\XLite\View\Product\Details\Customer\EditableAttributes',
        );
    }

    /**
     * Check - allowed display subwidget or not
     *
     * @param string $name Widget class name
     *
     * @return boolean
     */
    protected function isAllowedWidget($name)
    {
        $result = true;

        if ('\XLite\View\Price' == $name) {
            $types = $this->getProductModifierTypes();
            if (empty($types['price'])) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Get product modifier types
     *
     * @return array
     */
    protected function getProductModifierTypes()
    {
        if (!isset($this->productModifierTypes)) {
            foreach (\XLite\Model\Attribute::getTypes() as $type => $name) {
                $class = \XLite\Model\Attribute::getAttributeValueClass($type);
                if (is_subclass_of($class, 'XLite\Model\AttributeValue\Multiple')) {
                    $modifierTypes = \XLite\Core\Database::getRepo($class)
                        ->getModifierTypesByProduct($this->getProduct());
                    foreach ($modifierTypes as $k => $v) {
                        if (!isset($this->productModifierTypes[$k])) {
                            $this->productModifierTypes[$k] = $v;

                        } else {
                            $this->productModifierTypes[$k] = $this->productModifierTypes[$k] || $v;
                        }
                    }
                }
            }
        }

        return $this->productModifierTypes;
    }

    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    protected function getProduct()
    {
        return $this->getParam(static::PARAM_PRODUCT);
    }

    /**
     * Get default product
     *
     * @return \XLite\Model\Product
     */
    protected function getDefaultProduct()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Product')
            ->find(intval(\XLite\Core\Request::getInstance()->product_id));
    }
}
