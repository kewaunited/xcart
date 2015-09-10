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

namespace XLite\Module\XC\AuctionInc\View\FormField\Select;

/**
 * UPR entry point selector
 */
class EntryPointUPS extends AEntryPoint
{
    /**
     * Get default options for selector
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            static::STATE_DISABLED => 'Disable carrier',
            'D'                    => 'Drop-off',
            'O5'                   => 'On Call/Pickup Residential Same Day',
            'O6'                   => 'On Call/Pickup Residential Future Day',
            'O7'                   => 'On Call/Pickup Commercial Same Day',
            'O8'                   => 'On Call/Pickup Commerical Future Day',
            'P'                    => 'Daily Pickup (UPS Account started before 01-02-11)',
            'Q'                    => 'Daily Pickup (UPS Account started after 01-02-11)',
            'R'                    => 'Retail Location',
        );
    }
}
