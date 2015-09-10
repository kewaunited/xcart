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

namespace XLite\View\Model\Payment;

/**
 * Payment transaction view model
 */
class Transaction extends \XLite\View\Model\AModel
{
    /**
     * Shema default
     *
     * @var array
     */
    protected $schemaDefault = array(
        'date' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Date',
        ),
        'public_id' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Public ID',
        ),
        'method_name' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Method name',
        ),
        'type' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Type',
        ),
        'status' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Status',
        ),
        'value' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Value',
        ),
        'note' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Note',
        ),
    );

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->transaction_id;
    }

    /**
     * This object will be used if another one is not pased
     *
     * @return \XLite\Model\Payment\Transaction
     */
    protected function getDefaultModelObject()
    {
        $model = $this->getModelId()
            ? \XLite\Core\Database::getRepo('XLite\Model\Payment\Transaction')->find($this->getModelId())
            : null;

        return $model ?: new \XLite\Model\Payment\Transaction;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\View\Form\Model\Payment\Transaction';
    }

    /**
     * Retrieve property from the model object
     *
     * @param mixed $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        $result = parent::getModelObjectValue($name);

        switch ($name) {
            case 'date':
                $result = $this->formatTime($result);
                break;

            case 'method_name':
                $result = $this->getModelObject()->getPaymentMethod()
                    ? $this->getModelObject()->getPaymentMethod()->getName()
                    : $result;
                break;

            case 'type':
                $list = \XLite\Model\Payment\BackendTransaction::getTypes();
                $result = $list[$result];
                break;

            case 'status':
                $list = \XLite\Model\Payment\Transaction::getStatuses();
                $result = $list[$result];
                break;

            case 'value':
                $result = static::formatPrice($result, $this->getModelObject()->getCurrency());
                break;

            case 'note':
                if (!$result) {
                    $result = static::t('n/a');
                }
                break;

            default:

        }

        return $result;
    }

}
