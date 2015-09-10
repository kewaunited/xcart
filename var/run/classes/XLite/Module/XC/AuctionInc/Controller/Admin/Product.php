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

namespace XLite\Module\XC\AuctionInc\Controller\Admin;

/**
 * Product
 */
abstract class Product extends \XLite\Controller\Admin\ProductAbstract implements \XLite\Base\IDecorator
{
    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        if (!$this->isNew()) {
            $list['auctionInc'] = static::t('ShippingCalc');
        }

        return $list;
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();
        if (!$this->isNew()) {
            $list['auctionInc'] = 'modules/XC/AuctionInc/product.tpl';
        }

        return $list;
    }

    /**
     * Return model form object
     *
     * @param array $params Form constructor params OPTIONAL
     *
     * @return \XLite\View\Model\AModel
     */
    protected function getAuctionIncModelForm(array $params = array())
    {
        $class = 'XLite\Module\XC\AuctionInc\View\Model\ProductAuctionInc';

        return \XLite\Model\CachingFactory::getObject(
            __METHOD__ . $class . (empty($params) ? '' : md5(serialize($params))),
            $class,
            $params
        );
    }

    /**
     * Update AuctionInc related data
     *
     * @return void
     */
    protected function doActionUpdateAuctionInc()
    {
        $this->getAuctionIncModelForm()->performAction('modify');
    }

    /**
     * Update AuctionInc related data
     *
     * @return void
     */
    protected function doActionRestoreAuctionInc()
    {
        /** @var \XLite\Module\XC\AuctionInc\Model\ProductAuctionInc $auctionIncData */
        $auctionIncData = $this->getProduct()->getAuctionIncData();

        if ($auctionIncData && $auctionIncData->isPersistent()) {
            $auctionIncData->delete();
        }

        $this->setReturnURL(
            $this->buildURL(
                'product',
                null,
                array(
                    'product_id' => $this->getProductId(),
                    'page' => 'auctionInc',
                )
            )
        );
    }
}
