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

namespace XLite\Model\Payment\Base;

/**
 * Abstract online (gateway-based) processor
 */
abstract class Online extends \XLite\Model\Payment\Base\Processor
{
    /**
     * Default return transaction id field name
     */
    const RETURN_TXN_ID = 'txnId';


    /**
     * Return response type
     */
    const RETURN_TYPE_HTTP_REDIRECT = 'http';
    const RETURN_TYPE_HTML_REDIRECT = 'html';
    const RETURN_TYPE_HTML_REDIRECT_WITH_IFRAME_DESTROYING = 'html_iframe';
    const RETURN_TYPE_CUSTOM        = 'custom';


    /**
     * Process return
     *
     * @param \XLite\Model\Payment\Transaction $transaction Return-owner transaction
     *
     * @return void
     */
    public function processReturn(\XLite\Model\Payment\Transaction $transaction)
    {
        $this->transaction = $transaction;

        $this->logReturn(\XLite\Core\Request::getInstance()->getData());
    }

    /**
     * Get return type
     *
     * @return string
     */
    public function getReturnType()
    {
        return self::RETURN_TYPE_HTTP_REDIRECT;
    }

    /**
     * Process callback
     *
     * @param \XLite\Model\Payment\Transaction $transaction Callback-owner transaction
     *
     * @return void
     */
    public function processCallback(\XLite\Model\Payment\Transaction $transaction)
    {
        $this->transaction = $transaction;

        $this->logCallback(\XLite\Core\Request::getInstance()->getData());
    }

    /**
     * Get callback request owner transaction or null
     *
     * @return \XLite\Model\Payment\Transaction|void
     */
    public function getCallbackOwnerTransaction()
    {
        return null;
    }

    /**
     * Mark callback request as invalid
     *
     * @param string $message Message
     *
     * @return void
     */
    public function markCallbackRequestAsInvalid($message)
    {
        \XLite\Logger::getInstance()->log(
            'Callback request is invalid: ' . $message . PHP_EOL
            . 'Payment gateway: ' . $this->transaction->getPaymentMethod()->getServiceName() . PHP_EOL
            . 'order #' . $this->transaction->getOrder()->getOrderId()
            . ' / transaction #' . $this->transaction->getTransactionId() . PHP_EOL,
            LOG_WARNING
        );
    }


    /**
     * Get client IP
     *
     * @return string
     */
    protected function getClientIP()
    {
        $result = null;

        if (
            isset($_SERVER['REMOTE_ADDR'])
            && preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/Ss', $_SERVER['REMOTE_ADDR'])
        ) {
            $result = $_SERVER['REMOTE_ADDR'];
        }

        return $result;
    }

    /**
     * Get invoice description
     *
     * @return string
     */
    protected function getInvoiceDescription()
    {
        return 'Payment transaction: ' . $this->getTransactionId();
    }

    /**
     * Define saved into transaction data schema
     *
     * @return array
     */
    protected function defineSavedData()
    {
        return array();
    }

    /**
     * Save request data into transaction
     *
     * @return void
     */
    protected function saveDataFromRequest($backendTransaction = null)
    {
        $this->saveFilteredData(\XLite\Core\Request::getInstance()->getData(), $backendTransaction);
    }

    /**
     * Filter input array $data by keys and save in the transaction data
     *
     * @param array                                   $data               Array of data to save
     * @param \XLite\Model\Payment\BackendTransaction $backendTransaction Backend transaction object OPTIONAL
     *
     * @return void
     */
    protected function saveFilteredData($data, $backendTransaction = null)
    {
        foreach ($this->defineSavedData() as $key => $name) {
            if (isset($data[$key])) {
                $this->setDetail($key, $data[$key], $name, $backendTransaction);
            }
        }
    }

    /**
     * Array cell mask
     *
     * @param array  $list Array
     * @param string $name CEll key
     *
     * @return array
     */
    protected function maskCell(array $list, $name)
    {
        if (isset($list[$name])) {
            $list[$name] = str_repeat('*', strlen($list[$name]));
        }

        return $list;
    }

    /**
     * Log return request
     *
     * @param array $list Request data
     *
     * @return void
     */
    protected function logReturn(array $list)
    {
        \XLite\Logger::getInstance()->log(
            $this->transaction->getPaymentMethod()->getServiceName() . ' payment gateway : return' . PHP_EOL
            . 'Data: ' . var_export($list, true),
            LOG_DEBUG
        );
    }

    /**
     * Log callback
     *
     * @param array $list Callback data
     *
     * @return void
     */
    protected function logCallback(array $list)
    {
        \XLite\Logger::getInstance()->log(
            $this->transaction->getPaymentMethod()->getServiceName() . ' payment gateway : callback' . PHP_EOL
            . 'Data: ' . var_export($list, true),
            LOG_DEBUG
        );
    }

    /**
     * Get transactionId-based return URL
     *
     * @param string  $fieldName TransactionId field name OPTIONAL
     * @param boolean $withId    Add to URL transaction id or not OPTIONAL
     * @param boolean $asCancel  Mark URL as cancel action OPTIONAL
     *
     * @return string
     */
    protected function getReturnURL($fieldName = self::RETURN_TXN_ID, $withId = false, $asCancel = false)
    {
        $query = array(
            'txn_id_name' => $fieldName ?: self::RETURN_TXN_ID,
        );

        if ($withId) {
            $query[$query['txn_id_name']] = $this->transaction->getPublicTxnId();
        }

        if ($asCancel) {
            $query['cancel'] = 1;
        }

        return \XLite::getInstance()->getShopURL(
            \XLite\Core\Converter::buildURL('payment_return', '', $query),
            \XLite\Core\Config::getInstance()->Security->customer_security
        );
    }

    /**
     * Get transactionId-based callback URL
     *
     * @param string  $fieldName TransactionId field name OPTIONAL
     * @param boolean $withId    Add to URL transaction id or not OPTIONAL
     *
     * @return string
     */
    protected function getCallbackURL($fieldName = self::RETURN_TXN_ID, $withId = false)
    {
        $query = array(
            'txn_id_name' => $fieldName ?: self::RETURN_TXN_ID,
        );

        if ($withId) {
            $query[$query['txn_id_name']] = $this->transaction->getPublicTxnId();
        }

        return \XLite::getInstance()->getShopURL(
            \XLite\Core\Converter::buildURL('callback', '', $query),
            \XLite\Core\Config::getInstance()->Security->customer_security
        );
    }

    /**
     * Check total (transaction total and total from gateway response)
     *
     * @param float $total Total from gateway response
     *
     * @return boolean
     */
    protected function checkTotal($total)
    {
        $result = true;

        $currency = $this->transaction->getCurrency();
        if ($total && $currency->roundValue($this->transaction->getValue()) != $currency->roundValue($total)) {
            $msg = 'Total amount doesn\'t match. Transaction total: ' . $this->transaction->getValue()
                . '; payment gateway amount: ' . $total;
            $this->setDetail(
                'total_checking_error',
                $msg,
                'Hacking attempt'
            );

            $result = false;
        }

        return $result;
    }

    /**
     * Check currency (order currency and transaction response currency)
     *
     * @param string $currency Transaction response currency code
     *
     * @return boolean
     */
    protected function checkCurrency($currency)
    {
        $result = true;

        if ($currency && $this->transaction->getCurrency()->getCode() != $currency) {
            $msg = 'Currency code doesn\'t match. Order currency: '
                . $this->transaction->getCurrency()->getCode()
                . '; payment gateway currency: ' . $currency;
            $this->setDetail(
                'currency_checking_error',
                $msg,
                'Hacking attempt details'
            );

            $result = false;
        }

        return $result;
    }


}
