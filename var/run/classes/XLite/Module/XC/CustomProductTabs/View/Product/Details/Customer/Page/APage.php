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

namespace XLite\Module\XC\CustomProductTabs\View\Product\Details\Customer\Page;

/**
 * APage
 */
abstract class APage extends \XLite\Module\CDev\Sale\View\Details implements \XLite\Base\IDecorator
{
    /**
     * Define tabs
     *
     * @return array
     */
    protected function defineTabs()
    {
        $list = parent::defineTabs();
        $weight = 5000;

        foreach ($this->getProduct()->getTabs() as $tab) {
            if ($tab->getEnabled()) {
                $list['tab' . $tab->getId()] = array(
                    'widget'     => '\XLite\Module\XC\CustomProductTabs\View\Tab',
                    'parameters' => array(
                        'tab' => $tab,
                    ),
                    'name'       => $tab->getName(),
                    'weight'     => $weight,
                );
                $weight++;
            }
        }

        return $list;
    }
}
