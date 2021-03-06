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

namespace XLite\Module\CDev\FeaturedProducts\View\Customer;

/**
 * Featured products widget
 *
 * @ListChild (list="center.bottom", zone="customer", weight="300")
 */
class FeaturedProducts extends \XLite\View\ItemsList\Product\Customer\Category\ACategory
{

    /**
     * Featured products
     *
     * @var mixed
     */
    protected $featuredProducts;

    /**
     * Initialize widget (set attributes)
     *
     * @param array $params Widget params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        parent::setWidgetParams($params);

        $this->widgetParams[static::PARAM_DISPLAY_MODE]->setValue($this->getDisplayMode());
        $this->widgetParams[\XLite\View\Pager\APager::PARAM_SHOW_ITEMS_PER_PAGE_SELECTOR]->setValue(false);
        $this->widgetParams[\XLite\View\Pager\APager::PARAM_ITEMS_COUNT]->setValue(5);
    }

    /**
     * Get widget display mode
     *
     * @return string
     */
    protected function getDisplayMode()
    {
        return $this->getParam(static::PARAM_IS_EXPORTED)
            ? $this->getParam(static::PARAM_DISPLAY_MODE)
            : \XLite\Core\Config::getInstance()->CDev->FeaturedProducts->featured_products_look;
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Featured products';
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return '\XLite\View\Pager\Infinity';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[static::PARAM_GRID_COLUMNS]->setValue(3);

        unset($this->widgetParams[static::PARAM_SHOW_DISPLAY_MODE_SELECTOR]);
        unset($this->widgetParams[static::PARAM_SHOW_SORT_BY_SELECTOR]);
    }

    /**
     * Return products list
     *
     * @param \XLite\Core\CommonCell $cnd       Condition
     * @param boolean                $countOnly Count only flag
     *
     * @return array
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        if (null === $this->featuredProducts) {
            $products = array();
            $fp = \XLite\Core\Database::getRepo('XLite\Module\CDev\FeaturedProducts\Model\FeaturedProduct')
                ->getFeaturedProducts($this->getCategoryId());

            foreach ($fp as $product) {
                $products[] = $product->getProduct();
            }

            $this->featuredProducts = $products;
        }

        return true === $countOnly
            ? count($this->featuredProducts)
            : $this->featuredProducts;
    }

    // {{{ Cache

    /**
     * Cache allowed
     *
     * @param string $template Template
     *
     * @return boolean
     */
    protected function isCacheAllowed($template)
    {
        return parent::isCacheAllowed($template)
            && $this->isStaticProductList();
    }

    /**
     * Cache availability
     *
     * @return boolean
     */
    protected function isCacheAvailable()
    {
        return true;
    }

    /**
     * Get cache TTL (seconds)
     *
     * @return integer
     */
    protected function getCacheTTL()
    {
        return 3600;
    }

    // }}}

    /**
     * Register the CSS classes for this block
     *
     * @return string
     */
    protected function getBlockClasses()
    {
        return parent::getBlockClasses() . ' block-featured-products';
    }
}
