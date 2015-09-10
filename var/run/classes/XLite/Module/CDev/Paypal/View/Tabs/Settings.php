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

namespace XLite\Module\CDev\Paypal\View\Tabs;

/**
 * Tabs related to paypal settings page
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Settings extends \XLite\View\Tabs\ATabs
{
    /**
     * Description of tabs related to user profile section and their targets
     *
     * @var array
     */
    protected $tabs = array(
        'paypal_settings' => array(
            'title'    => 'Settings',
            'widget'   => 'XLite\Module\CDev\Paypal\View\Settings',
        ),
        'paypal_credit' => array(
            'title'    => 'Paypal Credit',
            'widget'   => 'XLite\Module\CDev\Paypal\View\Settings',
        ),
    );

    /**
     * Returns the list of targets where this widget is available
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'paypal_settings';
        $list[] = 'paypal_credit';

        return $list;
    }

    /**
     * Init
     *
     * @return void
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Returns an URL to a tab
     *
     * @param string $target Tab target
     *
     * @return string
     */
    protected function buildTabURL($target)
    {
        return $this->buildURL($target, '', array('method_id' => \XLite\Core\Request::getInstance()->method_id));
    }
}
