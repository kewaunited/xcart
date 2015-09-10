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

namespace XLite\Module\XC\NextPreviousProduct\View\ItemList\Product\Customer;

/**
 * Decorated ACustomer items list
 */
abstract class ACustomer extends \XLite\View\ItemsList\Product\Customer\ACustomer implements \XLite\Base\IDecorator
{
    /**
     * Item position on page
     *
     * @var integer
     */
    protected $position = 0;

    /**
     * Public wrapper for getSearchCondition()
     *
     * @return \XLite\Core\CommonCell
     */
    public function getSearchConditionWrapper()
    {
        return $this->getSearchCondition();
    }

    /**
     * Get a list of JavaScript files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/NextPreviousProduct/items-list/cookie-setter.js';

        return $list;
    }

    /**
     * Get three items around $itemPosition
     *
     * @param \XLite\Core\CommonCell $cnd          Condition for search
     * @param integer                $itemPosition Item position in condition
     *
     * @return array|integer
     */
    public function getNextPreviousItems($cnd, $itemPosition)
    {
        $cnd->limit = array(
            $itemPosition - 1,
            3,
        );

        return $this->getData($cnd);
    }

    /**
     * Public wrapper for getPager()
     *
     * @return \XLite\View\Pager\APager
     */
    public function getPagerWrapper()
    {
        return $this->getPager();
    }

    /**
     * json string for data attribute
     *
     * @return string
     */
    protected function getDataString()
    {
        return json_encode($this->defineDataForDataString());
    }

    /**
     * Define data for getDataString() method
     *
     * @return array
     */
    protected function defineDataForDataString()
    {
        return array(
            'class'      => get_called_class(),
            'pageId'     => $this->getPager()->getPageIdWrapper(),
            'position'   => $this->position++,
            'parameters' => array(),
        );
    }

    /**
     * Get cookie path
     *
     * @return string
     */
    protected function getCookiePath()
    {
        $result = null;

        if (
            LC_USE_CLEAN_URLS
            && (bool) \XLite::getInstance()->getOptions(array('clean_urls', 'use_canonical_urls_only'))
        ) {
            // Get store URL
            $url = \XLite\Core\Request::getInstance()->isHTTPS()
                ? 'http://' .  \XLite::getInstance()->getOptions(array('host_details', 'http_host'))
                : 'https://' . \XLite::getInstance()->getOptions(array('host_details', 'https_host'));

            $url .= \XLite::getInstance()->getOptions(array('host_details', 'web_dir'));

            $urlParts = parse_url($url);

            // Result is path to store
            $result = isset($urlParts['path']) ? $urlParts['path'] : '/';
        }

        return $result;
    }
}
