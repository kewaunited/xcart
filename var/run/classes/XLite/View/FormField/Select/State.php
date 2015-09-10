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

namespace XLite\View\FormField\Select;

/**
 * \XLite\View\FormField\Select\State
 */
class State extends \XLite\View\FormField\Select\Regular
{
    /**
     * Widget param names
     */
    const PARAM_COUNTRY = 'country';

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_COUNTRY => new \XLite\Model\WidgetParam\String('Country', ''),
        );
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'select_state.tpl';
    }

    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        $result = $this->getParam(static::PARAM_OPTIONS);

        if (!$result) {
            if ($this->getParam(static::PARAM_COUNTRY)) {
                $result = \XLite\Core\Database::getRepo('\XLite\Model\State')->findByCountryCodeGroupedByRegion(
                    $this->getParam(static::PARAM_COUNTRY)
                );
            }else{
                $result = \XLite\Core\Database::getRepo('\XLite\Model\State')->findAllStatesGrouped();
            }
        }

        return $result;
    }

    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array();
    }
}
