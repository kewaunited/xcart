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

namespace XLite\Module\XC\AuctionInc\View\Model;

/**
 * Auction inc configuration form model
 */
class Settings extends \XLite\View\Model\Settings
{
    /**
     * Get form field by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return array
     */
    protected function getFormFieldByOption(\XLite\Model\Config $option)
    {
        $cell = parent::getFormFieldByOption($option);

        switch ($option->getName()) {
            case 'trialEnabled':
            case 'entryPointSeparator':
            case 'entryPointDHL':
            case 'DHLAccessKey':
            case 'entryPointFEDEX':
            case 'entryPointUPS':
            case 'entryPointUSPS':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'accountId' => array(''),
                    ),
                );
                break;

            case 'fallbackRateValue':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'fallbackRate' => array('I', 'O'),
                    ),
                );
                break;

            case 'package':
            case 'insurable':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'calculationMethod' => array('C'),
                    ),
                );
                break;

            case 'fixedFeeMode':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'calculationMethod' => array('F'),
                    ),
                );
                break;

            case 'fixedFeeCode':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'calculationMethod' => array('F'),
                        'fixedFeeMode'      => array('C'),
                    ),
                );
                break;

            case 'fixedFee1':
            case 'fixedFee2':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'calculationMethod' => array('F'),
                        'fixedFeeMode'      => array('F'),
                    ),
                );
                break;
        }

        if ($option->getName() == 'trialEnabled') {
            if (!\XLite\Module\XC\AuctionInc\Main::isXSTrialPeriodValid()) {
                $cell[static::SCHEMA_VALUE] = false;
                $cell[\XLite\View\FormField\Input\Checkbox\OnOff::PARAM_DISABLED] = true;
            }
        }

        return $cell;
    }
}
