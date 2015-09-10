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

namespace XLite\Module\XC\CustomProductTabs\Controller\Admin;

/**
 * Product
 */
abstract class Product extends \XLite\Module\XC\AuctionInc\Controller\Admin\Product implements \XLite\Base\IDecorator
{
    /**
     * is edited tab
     *
     * @return boolean
     */
    public function isProductTabPage()
    {
        return isset(\XLite\Core\Request::getInstance()->tab_id);
    }

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        if (!$this->isNew()) {
            $list['tabs'] = static::t('Tabs');
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
            $list['tabs']    = 'modules/XC/CustomProductTabs/product/tabs.tpl';
        }

        return $list;
    }

    /**
     * Update product tabs list
     *
     * @return void
     */
    protected function doActionUpdateProductTabs()
    {
        $list = new \XLite\Module\XC\CustomProductTabs\View\ItemsList\Model\Product\Tab;
        $list->processQuick();
    }

    /**
     * Update product tab model
     *
     * @return void
     */
    protected function doActionUpdateProductTab()
    {
        if ($this->getModelForm()->performAction('modify')) {
            $this->setReturnUrl(
                \XLite\Core\Converter::buildURL(
                    'product',
                    null,
                    array(
                        'product_id' => \XLite\Core\Request::getInstance()->product_id,
                        'page'       => 'tabs',
                    )
                )
            );
        }
    }
    /**
     * Get model form class
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return \XLite\Core\Request::getInstance()->page == 'tabs'
            ? 'XLite\Module\XC\CustomProductTabs\View\Model\Product\Tab'
            : parent::getModelFormClass();
    }
}
