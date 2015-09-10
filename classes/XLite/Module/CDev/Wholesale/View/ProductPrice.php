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

namespace XLite\Module\CDev\Wholesale\View;

/**
 * Wholesale prices for product
 */
class ProductPrice extends \XLite\View\Product\Details\Customer\Widget
{
    /**
     * Cache for wholesale prices array
     *
     * @var   array
     */
    protected $wholesalePrices = null;

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/CDev/Wholesale/product_price/style.css';

        return $list;
    }

    /**
     * Return the specific widget service name to make it visible as specific CSS class
     *
     * @return null|string
     */
    public function getFingerprint()
    {
        return 'widget-fingerprint-product-wholesale-prices';
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/Wholesale/product_price/body.tpl';
    }

    /**
     * Define wholesale prices
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    protected function defineWholesalePrices()
    {
        return \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')->getWholesalePrices(
            $this->getProduct(),
            $this->getCart()->getProfile() ? $this->getCart()->getProfile()->getMembership() : null
        );
    }

    /**
     * Return wholesale prices for the current product
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    protected function getWholesalePrices()
    {
        if (!isset($this->wholesalePrices)) {
            $this->wholesalePrices = $this->defineWholesalePrices();

            $minQty = $this->getProduct()->getMinQuantity($this->getCart()->getProfile() ? $this->getCart()->getProfile()->getMembership() : null);
            if (
                $this->wholesalePrices
                && isset($this->wholesalePrices[0])
                && $minQty < $this->wholesalePrices[0]->getQuantityRangeBegin()
            ) {
                $class = get_class($this->wholesalePrices[0]);
                $basePrice = new $class;
                $basePrice->setPrice($this->wholesalePrices[0]->getOwner()->getBasePrice());
                $basePrice->setQuantityRangeBegin($minQty);
                $basePrice->setQuantityRangeEnd($this->wholesalePrices[0]->getQuantityRangeBegin() - 1);
                $basePrice->setOwner($this->wholesalePrices[0]->getOwner());
                array_unshift($this->wholesalePrices, $basePrice);
            }
        }

        return $this->wholesalePrices;
    }
}
