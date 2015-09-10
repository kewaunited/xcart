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

namespace XLite\Module\XC\Reviews\Model\Repo;

/**
 * Clean URL repository
 */
class CleanURL extends \XLite\Model\Repo\CleanURL implements \XLite\Base\IDecorator
{
    const REVIEWS_PREFIX = 'reviews-';

    /**
     * Parse clean URL
     * Return array((string) $target, (array) $params)
     *
     * @param string $url  Main part of a clean URL
     * @param string $last First part before the "url" OPTIONAL
     * @param string $rest Part before the "url" and "last" OPTIONAL
     * @param string $ext  Extension OPTIONAL
     *
     * @return array
     */
    protected function parseURLProduct($url, $last = '', $rest = '', $ext = '')
    {
        $result = null;

        if ($ext) {
            $result = parent::parseURLProduct($url, $last, $rest, $ext);

            if (empty($result) && 0 === strpos($url, static::REVIEWS_PREFIX)) {
                $url = preg_replace('/^' . preg_quote(static::REVIEWS_PREFIX) . '/', '', $url);
                $result = parent::parseURLProduct($url, $last, $rest, $ext);

                if ($result) {
                    $result[0] = 'product_reviews';
                }
            }
        }

        return $result;
    }

    /**
     * Hook for modules
     *
     * @param string $url    Main part of a clean URL
     * @param string $last   First part before the "url"
     * @param string $rest   Part before the "url" and "last"
     * @param string $ext    Extension
     * @param string $target Target
     * @param array  $params Additional params
     *
     * @return array
     */
    protected function prepareParseURL($url, $last, $rest, $ext, $target, $params)
    {
        list($newTarget, $params) = parent::prepareParseURL(
            $url,
            $last,
            $rest,
            $ext,
            'product_reviews' == $target ? 'product' : $target,
            $params
        );

        return array('product_reviews' == $target ? $target : $newTarget, $params);
    }

    /**
     * Build product URL
     *
     * @param array  $params Params
     *
     * @return array
     */
    protected function buildURLProductReviews($params)
    {
        list($urlParts, $params) = $this->buildURLProduct($params);

        if (!empty($urlParts)) {
            $urlParts[0] = static::REVIEWS_PREFIX . $urlParts[0];
        }

        return array($urlParts, $params);
    }

    /**
     * Hook for modules
     *
     * @param string $target   Target
     * @param array  $params   Params
     * @param array  $urlParts URL parts
     *
     * @return array
     */
    protected function prepareBuildURL($target, $params, $urlParts)
    {
        return parent::prepareBuildURL(
            'product_reviews' == $target ? 'product' : $target,
            $params,
            $urlParts
        );
    }
}
