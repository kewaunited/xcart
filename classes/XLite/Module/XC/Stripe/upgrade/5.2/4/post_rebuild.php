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

return function()
{
    $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array('service_name' => 'Stripe'));

    if ($method) {
        $isInTestMode = \XLite\View\FormField\Select\TestLiveMode::TEST === $method->getSetting('mode');

        $accessToken = $method->getSetting('accessToken');
        $publishKey = $method->getSetting('publishKey');

        $setting = new \XLite\Model\Payment\MethodSetting();

        $setting->setName('accessTokenTest');
        $setting->setValue($isInTestMode ? $accessToken : '');
        $setting->setPaymentMethod($method);
        $setting->persist();

        $method->addSettings($setting);

        $setting = new \XLite\Model\Payment\MethodSetting();

        $setting->setName('publishKeyTest');
        $setting->setValue($isInTestMode ? $publishKey : '');
        $setting->setPaymentMethod($method);
        $setting->persist();

        $method->addSettings($setting);

        if ($isInTestMode) {
            foreach ($method->getSettings() as $setting) {
                if (in_array($setting->getName(), array('accessToken', 'publishKey'))) {
                    $setting->setValue('');
                }
            }
        }

        \XLite\Core\Database::getEM()->flush();
    }
};
