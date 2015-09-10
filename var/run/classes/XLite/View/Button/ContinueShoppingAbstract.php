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

namespace XLite\View\Button;

/**
 * "Continue shopping" button
 */
abstract class ContinueShoppingAbstract extends \XLite\View\Button\Link
{
    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Continue shopping';
    }

    /**
     * getClass
     *
     * @return string
     */
    protected function getClass()
    {
        return trim(parent::getClass() . ' action continue');
    }

    /**
     * We make the full location path for the provided URL
     *
     * @return string
     */
    protected function getLocationURL()
    {
        $urlParams = $this->getContinueShoppingParams(\XLite\Core\Session::getInstance()->continueShoppingURL);

        $url = $urlParams
            ? \XLite::getController()->getURL($urlParams)
            : '';

        return \XLite::getInstance()->getShopURL($url);
    }

    /**
     * Get continue shopping params
     *
     * @param array $params URL params
     *
     * @return array
     */
    protected function getContinueShoppingParams($params)
    {
        return isset($params['target']) && in_array($params['target'], $this->getAllowedContinueShoppingTargets(), true)
            ? $params
            : null;
    }

    /**
     * Returns allowed continue shopping targets
     *
     * @return array
     */
    protected function getAllowedContinueShoppingTargets()
    {
        return array('product', 'category', 'search');
    }
}