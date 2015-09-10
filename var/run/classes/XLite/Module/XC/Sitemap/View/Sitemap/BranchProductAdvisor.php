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

namespace XLite\Module\XC\Sitemap\View\Sitemap;

/**
 *  This widget draws a tree's branch
 *
 * @LC_Dependencies ("CDev\ProductAdvisor")
 */
abstract class BranchProductAdvisor extends \XLite\Module\XC\Sitemap\View\Sitemap\BranchAbstract implements \XLite\Base\IDecorator
{

    /**
     * Get children
     * 
     * @param string  $type Page type
     * @param integer $id   Page ID
     *  
     * @return array
     */
    protected function getChildren($type, $id)
    {
        $result = parent::getChildren($type, $id);

        if ($type == static::PAGE_CATEGORY && $id == \XLite\Core\Database::getRepo('XLite\Model\Category')->getRootCategoryId()) {
            array_unshift($result, array(
                'type' => static::PAGE_STATIC,
                'id'   => '998',
                'name' => static::t('New arrivals'),
                'url'  => static::buildURL('new_arrivals'),
            ));        
            array_unshift($result, array(
                'type' => static::PAGE_STATIC,
                'id'   => '999',
                'name' => static::t('Coming soon'),
                'url'  => static::buildURL('coming_soon'),
            ));   
        }

        return $result;
    }

}
