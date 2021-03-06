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
 * @LC_Dependencies ("CDev\SimpleCMS")
 */
class BranchSimpleCMS extends \XLite\Module\XC\Sitemap\View\Sitemap\Branch implements \XLite\Base\IDecorator
{

    /**
     * Page types
     */
    const PAGE_STATIC_PAGE = 'A';

    /**
     * Return existence of children of this category
     *
     * @param string  $type Page type
     * @param integer $id   Page ID
     *
     * @return boolean
     */
    protected function hasChild($type, $id)
    {
        if (static::PAGE_STATIC_PAGE == $type) {
            $cnt = \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Page')
                ->countBy(array('enabled' => true));
            $result = $cnt > 0;

        } else {
            $result = parent::hasChild($type, $id);
        }

        return $result;
    }

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
        if (static::PAGE_STATIC_PAGE == $type) {
            $result = array();
            if (!$id) {
                $pages = \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Page')->findBy(array('enabled' => true));
                foreach ($pages as $page) {
                    $result[] = array(
                        'type' => static::PAGE_STATIC_PAGE,
                        'id'   => $page->getId(),
                        'name' => $page->getName(),
                        'url'  => static::buildURL('page', null, array('id' => $page->getId())),
                    );
                }
            }

        } else {
            $result = parent::getChildren($type, $id);

            if (empty($type)) {
                $result[] = array(
                    'type' => static::PAGE_STATIC_PAGE,
                    'id'   => 0,
                    'name' => static::t('Static pages'),
                );
            }
        }

        return $result;
    }

}
