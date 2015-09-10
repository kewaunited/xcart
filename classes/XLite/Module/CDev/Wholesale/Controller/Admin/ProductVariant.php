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

namespace XLite\Module\CDev\Wholesale\Controller\Admin;

/**
 * Product variant
 *
 * @LC_Dependencies("XC\ProductVariants")
 */
class ProductVariant extends \XLite\Module\XC\ProductVariants\Controller\Admin\ProductVariant implements \XLite\Base\IDecorator
{
    /**
     * Page key
     */
    const PAGE_WHOLESALE_PRICING = 'wholesale_pricing';

    /**
     * Get pages
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        $list[static::PAGE_WHOLESALE_PRICING] = static::t('Wholesale pricing');

        return $list;
    }

    /**
     * Check if wholesale prices enabled for current product
     *
     * @return boolean
     */
    public function isWholesalePricesEnabled()
    {
        return $this->getProductVariant()->getProduct()->isWholesalePricesEnabled();
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();
        $list[static::PAGE_WHOLESALE_PRICING] = 'modules/CDev/Wholesale/pricing/body.tpl';

        return $list;
    }

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionWholesalePricesUpdate()
    {
        $list = new \XLite\Module\CDev\Wholesale\View\ItemsList\WholesalePrices();
        $list->processQuick();

        // Additional correction to re-define end of subtotal range for each discount
        \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')
            ->correctQuantityRangeEnd($this->getProductVariant());
    }
}
