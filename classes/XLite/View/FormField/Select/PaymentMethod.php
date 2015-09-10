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
 * Payment method
 */
class PaymentMethod extends \XLite\View\FormField\Select\Regular
{
    /**
     * Deleted key code
     */
    const KEY_DELETED = 'deleted';
    const KEY_NONE    = 'none';

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $result = array();
        $list = array();

        // Get all active payment methods
        foreach (\XLite\Core\Database::getRepo('\XLite\Model\Payment\Method')->findAllActive() as $method) {
            $list[$method->getMethodId()] = $method->getName();
        }

        if ($this->getOrder() && $this->getOrder()->getPaymentTransactions()) {

            // Get current order payment method
            foreach ($this->getOrder()->getPaymentTransactions() as $t) {
                $savedMethod = $t->getPaymentMethod()
                    ? $t->getPaymentMethod()->getTitle()
                    : $t->getMethodLocalName();

                if ($savedMethod && !array_search($savedMethod, $list)) {
                    // Add saved payment method if it is not in the active payment methods list
                    $result[static::KEY_DELETED] = $savedMethod;
                    break;
                }
            }

            if (!isset($savedMethod)) {
                $result[static::KEY_NONE] = static::t('None');
            }
        }

        $result = $result + $list;

        return $result;
    }
}
