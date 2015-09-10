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
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\QSL\CloudSearch\Core;

use XLite\Core\Config;
use XLite\Core\Converter;
use XLite\Core\Database;
use XLite\Core\HTTP\Request;
use XLite\Core\URLManager;


/**
 * CloudSearch API client
 */
class ServiceApiClient extends \XLite\Base\Singleton
{
    /**
     * CloudSearch service access details
     */
    const CLOUD_SEARCH_DOMAIN = 'cloudsearch.x-cart.com';
    const CLOUD_SEARCH_REQUEST_SECRET_KEY_URL = '/api/v1/getkey';
    const CLOUD_SEARCH_REMOTE_IFRAME_URL = '/api/v1/iframe?key=';
    const CLOUD_SEARCH_REGISTER_URL = '/api/v1/register';

    /**
     * Register CloudSearch installation
     *
     * @return void
     */
    public function register()
    {
        $requestUrl = 'http://' . static::CLOUD_SEARCH_DOMAIN . static::CLOUD_SEARCH_REGISTER_URL;

        $shopUrl = $this->getShopUrl();

        $request = new Request($requestUrl);
        $request->body = array(
            'shopUrl' => $shopUrl,
            'shopType' => 'xc5',
            'format' => 'php',
        );

        $response = $request->sendRequest();

        if ($response && $response->code == 200) {
            $data = unserialize($response->body);

            if ($data && !empty($data['apiKey'])) {
                $this->storeApiKey($data['apiKey']);
            }
        }
    }

    /**
     * Ask CloudSearch server to send us a new secret key
     *
     * @return void
     */
    public function requestSecretKey()
    {
        $apiKey = Config::getInstance()->QSL->CloudSearch->api_key;

        $requestUrl = 'http://' . static::CLOUD_SEARCH_DOMAIN
            . static::CLOUD_SEARCH_REQUEST_SECRET_KEY_URL;

        $request = new Request($requestUrl);
        $request->body = array(
            'apiKey' => $apiKey,
        );

        $request->sendRequest();
    }

    /**
     * Get CloudSearch dashboard url
     *
     * @param $secretKey
     *
     * @return string
     */
    public function getDashboardIframeUrl($secretKey)
    {
        return 'https://' . static::CLOUD_SEARCH_DOMAIN
        . static::CLOUD_SEARCH_REMOTE_IFRAME_URL . $secretKey;
    }

    /**
     * Get store url without script part
     *
     * @return string
     */
    protected function getShopUrl()
    {
        $shopUrl = URLManager::getShopURL(Converter::buildURL());

        $shopUrl = preg_replace('/[^\/]*.php$/', '', $shopUrl);

        return $shopUrl;
    }

    /**
     * Store API key in the DB
     *
     * @param $key
     *
     * @return void
     */
    protected function storeApiKey($key)
    {
        $repo = Database::getRepo('XLite\Model\Config');

        $secretKeySetting = $repo->findOneBy(array(
            'name' => 'api_key',
            'category' => 'QSL\CloudSearch'
        ));

        $secretKeySetting->setValue($key);

        Database::getEM()->flush();
    }
}