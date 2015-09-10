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

namespace XLite\Module\CDev\Wholesale\View\FormField;

/**
 * Wholesale prices
 *
 * @LC_Dependencies("XC\ProductVariants")
 */
class WholesalePrices extends \XLite\View\FormField\Inline\Label
{
    /**
     * Wholesale prices
     *
     * @var array
     */
    protected $wholesalePrices;

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/Wholesale/form_field/wholesale_prices.css';

        return $list;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/Wholesale/form_field/wholesale_prices.tpl';
    }

    /**
     * Return wholesale prices
     *
     * @return array
     */
    protected function getWholesalePrices()
    {
        if (!isset($this->wholesalePrices)) {
            $cnd = new \XLite\Core\CommonCell;
            $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\Base\AWholesalePrice::P_ORDER_BY_MEMBERSHIP} = true;
            $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\Base\AWholesalePrice::P_ORDER_BY} = array('w.quantityRangeBegin', 'ASC');

            if ($this->getEntity()->getDefaultPrice()) {
                $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\WholesalePrice::P_PRODUCT} = $this->getEntity()->getProduct();

                $this->wholesalePrices = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')->search($cnd);

            } else {

                $cnd->{\XLite\Module\CDev\Wholesale\Model\Repo\ProductVariantWholesalePrice::P_PRODUCT_VARIANT} = $this->getEntity();

                $this->wholesalePrices = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')->search($cnd);
            }
        }

        return $this->wholesalePrices;
    }

    /**
     * Return link
     *
     * @return string
     */
    protected function getLink()
    {
        return $this->getEntity()->getDefaultPrice()
            ? $this->buildURL('product', null, array('product_id' => $this->getEntity()->getProduct()->getId(), 'page' => 'wholesale_pricing'))
            : $this->buildURL('product_variant', null, array('id' => $this->getEntity()->getId(), 'page' => 'wholesale_pricing'));
    }
}
