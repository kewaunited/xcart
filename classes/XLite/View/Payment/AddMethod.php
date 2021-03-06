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

namespace XLite\View\Payment;

/**
 * Add payment method dialog widget
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class AddMethod extends \XLite\View\SimpleDialog
{
    /**
     * Cache flag for hasAllAllInOneMethods helper
     *
     * @see self::hasAllAllInOneMethods
     *
     * @var boolean|null
     */
    protected $allAllInOneMethods = null;

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'payment_method_selection';

        return $list;
    }

    /**
     * Return file name for the center part template
     *
     * @return string
     */
    protected function getBody()
    {
        return 'payment/add_method/body.tpl';
    }

    /**
     * Return payment methods type which is provided to the widget
     *
     * @return string
     */
    protected function getPaymentType()
    {
        return \XLite\Core\Request::getInstance()->{\XLite\View\Button\Payment\AddMethod::PARAM_PAYMENT_METHOD_TYPE};
    }

    /**
     * Defines if all ALLINONE methods are already added
     *
     * @return boolean
     */
    protected function hasAllAllInOneMethods()
    {
        if (is_null($this->allAllInOneMethods)) {
            // Defines if there is not added ALLINONE method
            $this->allAllInOneMethods = !(bool)\XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(array(
                'type'    => \XLite\Model\Payment\Method::TYPE_ALLINONE,
                'added'   => false,
            ));
        }

        return $this->allAllInOneMethods;
    }
}
