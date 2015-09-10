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

namespace XLite\Module\CDev\XPaymentsConnector\Core;

/**
 * XPayments client
 */
class XPaymentsClient extends \XLite\Base\Singleton
{
    const REQ_CURL    = 1;
    const REQ_OPENSSL = 2;
    const REQ_DOM     = 4;

    const XPC_SYSERR_CARTID      = 1;
    const XPC_SYSERR_URL         = 2;
    const XPC_SYSERR_PUBKEY      = 4;
    const XPC_SYSERR_PRIVKEY     = 8;
    const XPC_SYSERR_PRIVKEYPASS = 16;

    /**
     * Log file names
     */
    const LOG_FILE       = 'xp-connector';
    const LOG_FILE_ERROR = 'xp-connector-error';

    protected $apiRequest = null;

    /**
     * Check - module is configured or not
     *
     * @return boolean
     */
    public function isModuleConfigured()
    {
        return 0 === $this->getModuleSystemErrors();
    }

    /**
     * Make test request to X-Payments
     *
     * @param string $apiVersion API version, overrides configuration value OPTIONAL
     *
     * @return boolean
     */
    public function requestTest($apiVersion = false)
    {
        $hashCode = strval(rand(0, 1000000));

        // Make test request
        $test = $this->apiRequest->send(
            'connect',
            'test',
            array('testCode' => $hashCode),
            $apiVersion
        );

        // Compare MD5 hashes
        if ($test->isSuccess()) {

            $response = $test->getResponse();

            if (md5($hashCode) !== $response['hashCode']) {
                $test->setError('Test connection data is not valid');
            }
        }

        return $test;
    }

    /**
     * Get payment info
     *
     * @param integer $txnId   Transaction id
     * @param boolean $refresh Refresh OPTIONAL
     *
     * @return array Operation status & payment data array
     */
    public function requestPaymentInfo($txnId, $refresh = false)
    {
        $data = array(
            'txnId'   => $txnId,
            'refresh' => $refresh ? 1 : 0
        );

        return $this->apiRequest->send('payment', 'get_info', $data);
    }

    /**
     * Get payment info
     *
     * @param integer $txnId   Transaction id
     *
     * @return array Operation status & payment data array
     */
    public function requestPaymentAdditionalInfo($txnId)
    {
        $data = array(
            'txnId'   => $txnId,
        );

        return $this->apiRequest->send('payment', 'get_additional_info', $data);
    }

    /**
     * Get list of available payment configurations from X-Payments
     *
     * @return array
     */
    public function requestPaymentMethods()
    {
        $result = array();

        $confs = $this->apiRequest->send('payment_confs', 'get');

        if ($confs->isSuccess()) {
           
            $response = $confs->getResponse();
 
            if (
                !empty($response['payment_module'])
                && is_array($response['payment_module'])
            ) {
                $result = $response['payment_module'];
            }
        }

        return $result;
    }

    /**
     * Get recharge request via saved credit card 
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     * @param string                           $description Description OPTIONAL
     *
     * @return array
     */
    public function requestPaymentRecharge($txnId, \XLite\Model\Payment\Transaction $transaction, $description = null)
    {
        $xpcBackReference = $this->generateXpcBackReference();

        // Save back refernece to transaction from  X-Payments
        $transaction->setDataCell('xpcBackReference', $xpcBackReference, 'X-Payments back reference', 'C');
        \XLite\Core\Database::getEM()->flush();

        return $this->apiRequest->send(
            'payment',
            'recharge',
            array(
                'callbackUrl' => self::getCallbackUrl($xpcBackReference),
                'txnId'       => $txnId,
                'amount'      => $transaction->getValue(),
                'description' => !isset($description) ? 'New payment for tranaction #' . $txnId : $description 
            )
        );
    }

    /**
     * Capture request 
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     * @param int                              $amount      Amount OPTIONAL
     *
     * @return array
     */
    public function requestPaymentCapture($txnId, \XLite\Model\Payment\Transaction $transaction, $amount = null)
    {
        $data = array(
            'txnId' => $txnId,
        );

        if ($amount && is_numeric($amount)) {
            $data['amount'] = $amount;
        } 

        return $this->apiRequest->send('payment', 'capture', $data);
    }

    /**
     * Void request
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     * @param int                              $amount      Amount OPTIONAL
     *
     * @return array
     */
    public function requestPaymentVoid($txnId, \XLite\Model\Payment\Transaction $transaction, $amount = null)
    {
        $data = array(
            'txnId' => $txnId,
        );

        if ($amount && is_numeric($amount)) {
            $data['amount'] = $amount;
        }

        return $this->apiRequest->send('payment', 'void', $data);
    }

    /**
     * Refund request
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     * @param int                              $amount      Amount OPTIONAL
     *
     * @return array
     */
    public function requestPaymentRefund($txnId, \XLite\Model\Payment\Transaction $transaction, $amount = null)
    {
        $data = array(
            'txnId' => $txnId,
        );

        if ($amount && is_numeric($amount)) {
            $data['amount'] = $amount;
        }

        return $this->apiRequest->send('payment', 'refund', $data);
    }

    /**
     * Accept request
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     *
     * @return array
     */
    public function requestPaymentAccept($txnId, \XLite\Model\Payment\Transaction $transaction)
    {
        $data = array(
            'txnId' => $txnId,
        );

        return $this->apiRequest->send('payment', 'accept', $data);
    }

    /**
     * Decline request
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     *
     * @return array
     */
    public function requestPaymentDecline($txnId, \XLite\Model\Payment\Transaction $transaction)
    {
        $data = array(
            'txnId' => $txnId,
        );

        return $this->apiRequest->send('payment', 'decline', $data);
    }

    /**
     * Clear init payment form data from session
     *
     * @param integer $paymentId Payment id OPTIONAL
     *
     * @return void
     */
    public function clearInitDataFromSession($paymentId = null)
    {
        if (
            $paymentId
            && \XLite\Core\Session::getInstance()->xpc_form_data
            && \XLite\Core\Session::getInstance()->xpc_form_data[$paymentId]
        ) {

            unset(\XLite\Core\Session::getInstance()->xpc_form_data[$paymentId]);

        } else {

            unset(\XLite\Core\Session::getInstance()->xpc_form_data);

        }
    }

    /**
     * Check if data is valid for init payment form
     * It should contain form fields and transaction ID
     *
     * For session operations only
     *
     * @param array $data Data
     *
     * @return boolean
     */
    protected function isInitDataValid($data)
    {
        return !empty($data)
            && is_array($data)
            && !empty($data['txnId'])
            && !empty($data['xpcBackReference'])
            && is_array($data['fields'])
            && !empty($data['fields']);
    }

    /**
     * Save init payment form data to session
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction OPTIONAL
     * @param array                            $data        Form data OPTIONAL
     *
     * @return void 
     */
    public function saveInitDataToSession(\XLite\Model\Payment\Transaction $transaction = null, $data = null)
    {
        if ($transaction && $this->isInitDataValid($data)) {
            $formData = \XLite\Core\Session::getInstance()->xpc_form_data;

            if (!is_array($formData)) {
                $formData = array();
            }

            $data['savedCart'] = $this->prepareCart($transaction->getOrder(), $transaction->getPaymentMethod());

            $formData[$transaction->getPaymentMethod()->getMethodId()] = $data;

        } else {
            $formData = null;
        }

        \XLite\Core\Session::getInstance()->xpc_form_data = $formData;
    }

    /**
     * Get redirect form fields list
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array
     */
    public function getFormFields(\XLite\Model\Payment\Transaction $transaction)
    {
        // 1. Try to get data from session
        $data = $this->getInitDataFromSession($transaction);

        if (!$data) {

            // 2. Try to get data from X-Payments
            $data = $this->getInitDataFromXpayments($transaction);
        }

        if ($data) {

            // Save X-Payments transaction id in transaction data
            $transaction->setDataCell('xpc_txnid', $data['txnId'], 'X-Payments transaction id', 'C');

            // Save back refernece to transaction from  X-Payments 
            $transaction->setDataCell('xpcBackReference', $data['xpcBackReference'], 'X-Payments back reference', 'C');

            try {
                \XLite\Core\Database::getEM()->flush();

            } catch (Exception $e) {
                $this->setXpcInitError($transaction, 'Internal error. Unable to update transaction');
            }

            $data = $data['fields'];

        } else {

            $data = array();
        }

        return $data;
    }

    /**
     * Create a cart with fake item
     *
     * @param \XLite\Model\Profile $profile Customer's profile for whom the cart is created for
     * @param \XLite\Model\Payment\Method $paymentMethod Payment methood
     * @param \XLite\Model\Currency $currency Currency
     * @param $total Cart total
     * @param $itemName Name of the fake item
     * @param $itemSku SKU of the fake item
     *
     * @return \XLite\Model\Cart
     */
    public function createFakeCart(\XLite\Model\Profile $profile, \XLite\Model\Payment\Method $paymentMethod, \XLite\Model\Currency $currency, $total, $itemName, $itemSku)
    {
        $cart = new \XLite\Model\Cart;

        $cart->setTotal($total);
        $cart->setDate(time());
        $cart->setOrderNumber(\XLite\Core\Database::getRepo('XLite\Model\Order')->findNextOrderNumber());

        $cart->setProfile($profile);

        $cart->setCurrency($currency);
        $cart->setPaymentMethod($paymentMethod, $total);

        \XLite\Core\Database::getEM()->persist($cart);
        \XLite\Core\Database::getEM()->flush();

        $item = new \XLite\Model\OrderItem;
        $item->setName($itemName);
        $item->setSku($itemSku);
        $item->setPrice($total);
        $item->setAmount(1);
        $item->setTotal($total);
        $item->setXpcFakeItem(true);

        \XLite\Core\Database::getEM()->persist($item);
        \XLite\Core\Database::getEM()->flush();

        $cart->addItem($item);

        if (count($cart->getPaymentTransactions()) == 0) {

            // We cannot use first open transaction later, so we need to create it
            $transaction = new \XLite\Model\Payment\Transaction;

            $transaction->setPaymentMethod($paymentMethod);

            $transaction->setValue($total);

            $cart->addPaymentTransactions($transaction);
            $transaction->setOrder($cart);
        }

        return $cart;
    }

    /**
     * Prepare address data
     *
     * @param \XLite\Model\Profile $profile Customer's profile
     * @param $type Address type, billing or shipping
     *
     * @return array
     */
    protected function prepareAddress(\XLite\Model\Profile $profile, $type = 'billing')
    {
        $result = array();

        $addressFields = array(
            'firstname' => 'N/A',
            'lastname'  => '',
            'address'   => 'N/A',
            'city'      => 'N/A',
            'state'     => 'N/A',
            'country'   => 'N/A',
            'zipcode'   => 'N/A',
            'phone'     => '',
            'fax'       => '',
            'company'   => '',
        );

        $repo = \XLite\Core\Database::getRepo('\XLite\Model\AddressField');

        $type = $type . 'Address';

        foreach ($addressFields as $field => $defValue) {

            $method = 'address' == $field ? 'street' : $field;
            $address = $profile->$type;

            if (
                $address
                && ($repo->findOneBy(array('serviceName' => $method)) || method_exists($address, 'get' . $method))
                && $address->$method
            ) {
                $result[$field] = is_object($profile->$type->$method)
                    ? $profile->$type->$method->getCode()
                    : $profile->$type->$method;
            }

            if (empty($result[$field])) {
                $result[$field] = $defValue;
            }
        }

        $result['email'] = $profile->getLogin();

        return $result;
    }

    /**
     * Currency adjusted to payment method (or to all methods in old versions)
     *
     * @param \XLite\Model\Payment\Method   $paymentMethod  Payment method
     *
     * @return \XLite\Model\Currency 
     */
    public function getCurrencyForPaymentMethod(\XLite\Model\Payment\Method $paymentMethod)
    {
        $currencyId = version_compare(\XLite\Core\Config::getInstance()->CDev->XPaymentsConnector->xpc_api_version, '1.3') >= 0
            ? $paymentMethod->getSetting('currency')
            : \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector->xpc_currency;

        $currency = \XLite\Core\Database::getRepo('XLite\Model\Currency')->find($currencyId);

        return $currency;
    }

    /**
     * Currency coode to send to X-Payments
     *
     * @param \XLite\Model\Payment\Method   $paymentMethod  Payment method
     *
     * @return integer 
     */
    protected function getCurrencyCode(\XLite\Model\Payment\Method $paymentMethod)
    {
        return $this->getCurrencyForPaymentMethod($paymentMethod)->getCode();
    }

    /**
     * Round currency
     *
     * @param float $data Data
     *
     * @return float
     */
    protected function roundCurrency($data)
    {
        return sprintf('%01.2f', round($data, 2));
    }

    /**
     * Prepare shopping cart data
     *
     * @param \XLite\Model\Order            $cart           X-Cart shopping cart
     * @param \XLite\Model\Payment\Method   $paymentMethod  Payment method
     * @param integer                       $refId          Transaction ID OPTIONAL
     * @param boolean                       $forceAuth      Force enable AUTH mode OPTIONAL
     *
     * @return array
     */
    public function prepareCart(\XLite\Model\Order $cart, \XLite\Model\Payment\Method $paymentMethod, $refId = null, $forceAuth = false)
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        $profile = $cart->getProfile();

        $result = array(
            'login'                => $profile->getLogin() . ' (User ID #' . $profile->getProfileId() . ')',
            'items'                => array(),
            'currency'             => $this->getCurrencyCode($paymentMethod),
            'shippingCost'         => 0.00,
            'taxCost'              => 0.00,
            'discount'             => 0.00,
            'totalCost'            => 0.00,
            'description'          => 'Order#' . $cart->getOrderNumber(),
            'merchantEmail'        => \XLite\Core\Config::getInstance()->Company->orders_department,
            'forceTransactionType' => $forceAuth ? 'A' : '',
        );

        $result['billingAddress'] = $this->prepareAddress($profile);

        if ($profile->getShippingAddress()) {
            $result['shippingAddress'] = $this->prepareAddress($profile, 'shipping');
        } else {
            $result['shippingAddress'] = $result['billingAddress'];
        }

        // Set items
        if ($cart->getItems()) {

            foreach ($cart->getItems() as $item) {

                $itemElement = array(
                    'sku'      => strval($item->getSku() ? $item->getSku() : $item->getName()),
                    'name'     => strval($item->getName() ? $item->getName() : $item->getSku()),
                    'price'    => $this->roundCurrency($item->getPrice()),
                    'quantity' => $item->getAmount(),
                );

                if (!$itemElement['sku']) {
                    $itemElement['sku'] = 'N/A';
                }

                if (!$itemElement['name']) {
                    $itemElement['name'] = 'N/A';
                }

                $result['items'][] = $itemElement;
            }
        }

        // Set costs
        $result['shippingCost'] = $this->roundCurrency(
            $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, false)
        );
        $result['taxCost'] = $this->roundCurrency(
            $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_TAX, false)
        );
        $result['totalCost'] = $this->roundCurrency($cart->getTotal());
        $result['discount'] = $this->roundCurrency(
            abs($cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_DISCOUNT, false))
        );

        return $result;
    }

    /**
     * Compose error message from message and code
     * (It's here for the regexp in the next method)
     *
     * @param string $code Error code
     * @param string $message Error message
     *
     * @return string 
     */
    public function composeErrorMessage($code = '', $message = '')
    {
        $error = '';

        if ($code) {

            $error = 'X-Payments error (code: ' . $code . ') ';

            if ($message) {
                $error .= ' ' . $message;
            }

        } elseif ($message) {

            $error = $message;

        } else {

            $error = \XLite\Model\Payment\Transaction::getDefaultFailedReason(); 
        }

        return $error;
    }

    /**
     * Parse message to extract error code
     *
     * @param string $message Message
     *
     * @return array
     */
    public function parseErrorMessage($message)
    {
        $code = false;

        if (preg_match('/X-Payments error \(code: (\d+)\) (.*)$/', $message, $m)) {

            $code = $m[1];
            $message = $m[2];
        }

        return array($code, $message);
    }    

    /**
     * The payment method should be changed according to the error message or not
     *
     * @param string $message Error message
     *
     * @return bool 
     */
    protected function isChangeMethodMessage($message)
    {
        static $codes = array(
            '502', // Payment configuration is not initialized
            '503', // Unable to create a new payment
            '504', // Specified currency is not allowed
            '505', // Payment interface template files have been modified
            '506', // API Version mismatch
        );

        list($code, $message) = $this->parseErrorMessage($message);

        return in_array($code, $codes);
    }

    /**
     * Set X-Payments API error to:
     *  - Logs
     *  - Transaction data
     *  - Controller
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     * @param string $message Error message
     *
     * @return void
     */
    protected function setXpcInitError(\XLite\Model\Payment\Transaction $transaction, $message = '')
    {
        self::writeLogError('X-Paymets payment initialization failed: ' . $message);

        $transaction->setDataCell('status', $message, 'X-Payments error', 'C');
        $transaction->setNote($message);

        $iframe = \XLite::getController()->getIframe();

        $iframe->setError($message);

        if (\XLite::getController()->isCheckoutReady()) {

            $type = $this->isChangeMethodMessage($message)
                ? \XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_CHANGE_METHOD
                : \XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_ALERT;

            $iframe->setType($type);

        } else {
            $iframe->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_DO_NOTHING);
        }

        $this->clearInitDataFromSession();

        $iframe->finalize();
    }

    /**
     * Get init payment form data from session 
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array || bool
     */
    protected function getInitDataFromSession(\XLite\Model\Payment\Transaction $transaction)
    {
        $paymentId = $transaction->getPaymentMethod()->getMethodId();

        $formData = \XLite\Core\Session::getInstance()->xpc_form_data;

        $data = ($formData && $formData[$paymentId] && $this->isInitDataValid($formData[$paymentId]))
            ? $formData[$paymentId]
            : false;

        if (
            $data
            && !empty($data['savedCart'])
            && is_array($data['savedCart'])
            && $this->isCartFingerprintDifferent($data['savedCart'], $this->prepareCart(\XLite\Model\Cart::getInstance(), $transaction->getPaymentMethod()))
        ) {
            $this->clearInitDataFromSession($paymentId);
            $data = false;
        }

        return $data;
    }

    /**
     * Get init payment form data from XPayments
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array 
     */
    protected function getInitDataFromXpayments(\XLite\Model\Payment\Transaction $transaction)
    {
        $init = $this->requestPaymentInit(
            $transaction->getPaymentMethod(),
            \XLite\Model\Cart::getInstance()
        );

        if ($init->isSuccess()) {

            $response = $init->getResponse();

            $data = array(
                'xpcBackReference' => $response['xpcBackReference'],
                'txnId'            => $response['txnId'],
                'fields'           => $response['fields'],
            );

            $this->saveInitDataToSession($transaction, $data);

        } else {

            $data = null;
            $this->setXpcInitError($transaction, $init->getError());
        }

        return $data;
    }

    /**
     * Back reference from X-Payments to X-Cart 5.
     * We cannot use Order ID, Order number, Transaction ID etc,
     * since these values can change
     *
     * @return string
     */
    protected function generateXpcBackReference()
    {
        return md5(uniqid('', true) . time());
    }

    /**
     * Check - cart fingerprint is different or not
     * 
     * @param array $old Old saved cart 
     * @param array $new Current cart
     *  
     * @return boolean
     */
    protected function isCartFingerprintDifferent(array $old, array $new)
    {
        return $old != $new;
    }

    /**
     * Get return to the store URL 
     *
     * @param string $xpcBackReference Reference between X-Payments payment and X-Cart transaction 
     * @param bool $forZeroAuth Return to add to card page or to checkout
     *
     * @return string
     */
    public static function getReturnUrl($xpcBackReference, $forZeroAuth = false)
    {
        if (!$forZeroAuth) {

            // Return to the regular checkout page

            $url = \XLite\Core\Converter::buildUrl(
                'payment_return',
                'return',
                array('xpcBackReference' => $xpcBackReference),
                \XLite::CART_SELF
            );

        } else {

            // return to the add new card page

            $url = \XLite\Core\Converter::buildUrl(
                'add_new_card',
                'return',
                array('xpcBackReference' => $xpcBackReference),
                \XLite::CART_SELF
            );
        }

        return \XLite::getInstance()->getShopUrl($url);
    }

    /**
     * Get callback URL
     *
     * @param string $xpcBackReference Reference between X-Payments payment and X-Cart transaction
     * @param bool $forZeroAuth Call back for zero auth or regular order
     *
     * @return string
     */
    public static function getCallbackUrl($xpcBackReference)
    {
        if (!$forZeroAuth) {

            // Order callback

            $url = \XLite\Core\Converter::buildUrl(
                'callback',
                'callback',
                array('xpcBackReference' => $xpcBackReference),
                \XLite::CART_SELF
            );
        } else {

            // Add new card callback

            $url = \XLite\Core\Converter::buildUrl(
                'callback',
                'callback',
                array(
                    'xpcBackReference' => $xpcBackReference,
                    'for_zero_auth' => '1'
                ),
                \XLite::CART_SELF
            );
        }

        return \XLite::getInstance()->getShopUrl($url);
    }

    /**
     * For compatibiilty with mobile devices iframe is not used 
     *
     * @return bool
     */
    public static function isMobileDeviceCompatible()
    {
        $mobileExists = method_exists('\XLite\Core\Request', 'isMobileDevice')
            && \XLite\Core\Request::isMobileDevice();

        $mobileEnabled = method_exists(\XLite\Core\Request::getInstance(), 'isMobileEnabled')
            && \XLite\Core\Request::isMobileEnabled();

        return $mobileExists && $mobileEnabled;
    }

    /**
     * Get Data for specific API versions 
     * 
     * @return array
     */
    protected function getExtraData()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        $data = array();

        // API v1.3 abd higher
        if (version_compare($config->xpc_api_version, '1.3') >= 0) {

            // For mobile devices the tempate is default, and should be displayed on a separate page
            if (self::isMobileDeviceCompatible()) {
                $data['template'] = 'default';
            }

            // Save card at checkout flag
            $data['saveCard'] = 'Y' == \XLite\Core\Request::getInstance()->save_card
                ? 'Y'
                : 'N';
        }
        
        return $data;
    }

    /**
     * Get data hash for initial payment request
     *
     * @param int $confId Configuration ID in X-Payments
     * @param string $xpcBackReference Reference between X-Payments payment and X-Cart transaction
     * @param array $preparedCart Cart data
     *
     * @return array
     */
    protected function getInitRequestData($confId, $xpcBackReference, $preparedCart)
    {
        $data = array(
            'confId'      => $confId,
            'refId'       => $xpcBackReference,
            'cart'        => $preparedCart,
            'language'    => 'en',
            'returnUrl'   => self::getReturnUrl($xpcBackReference),
            'callbackUrl' => self::getCallbackUrl($xpcBackReference),
        );

        // Add API-specific data
        $data += $this->getExtraData();

        return $data;
    }

    /**
     * Send request to X-Payments to initialize new payment
     *
     * @param \XLite\Model\Payment\Method $paymentMethod Payment method
     * @param \XLite\Model\Cart           $cart          Shopping cart info
     * @param boolean                     $forceAuth     Force enable AUTH mode OPTIONAL
     *
     * @return array
     */
    protected function requestPaymentInit(\XLite\Model\Payment\Method $paymentMethod, \XLite\Model\Cart $cart, $forceAuth = false)
    {
        // Prepare cart
        $preparedCart = $this->prepareCart($cart, $paymentMethod, null, $forceAuth);

        if ($cart && $preparedCart) {

            $xpcBackReference = $this->generateXpcBackReference();

            // Send request to X-Payments
            $result = $this->apiRequest->send(
                'payment',
                'init',
                $this->getInitRequestData($paymentMethod->getSetting('id'), $xpcBackReference, $preparedCart)
            );

            if ($result->isSuccess()) {

                $response = $result->getResponse();

                // Set fields for the "Redirect to X-Payments" form
                $result->setResponse(array(
                    'xpcBackReference' => $xpcBackReference,
                    'txnId'            => $response['txnId'],
                    'module_name'      => $paymentMethod->getSetting('moduleName'),
                    'url'              => \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector->xpc_xpayments_url . '/payment.php',
                    'fields'           => array(
                        'target' => 'main',
                        'action' => 'start',
                        'token'  => $response['token'],
                    ),
                ));
            }

        } else {

            // Something is wrong with the cart. Should not ever happen
            $result = new \XLite\Module\CDev\XPaymentsConnector\Transport\Response;
            $result->setError('Unable to prepare cart data');
        }

        return $result;
    }

    /**
     * Get X-Payments Connector configuration errors
     *
     * @return integer
     */
    protected function getModuleSystemErrors()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        $failed = 0;

        // Check shopping cart id
        if (
            empty($config->xpc_shopping_cart_id)
            || !preg_match('/^[\da-f]{32}$/Ss', $config->xpc_shopping_cart_id)
        ) {
            $failed |= static::XPC_SYSERR_CARTID;
        }

        // Check URL
        if (empty($config->xpc_xpayments_url)) {
            $failed |= static::XPC_SYSERR_URL;
        }

        $parsedURL = @parse_url($config->xpc_xpayments_url);

        if (
            !$parsedURL
            || !isset($parsedURL['scheme'])
            || !in_array($parsedURL['scheme'], array( 'https', 'http'))
        ) {
            $failed |= static::XPC_SYSERR_URL;
        }

        // Check public key
        if (empty($config->xpc_public_key)) {
            $failed |= static::XPC_SYSERR_PUBKEY;
        }

        // Check private key
        if (empty($config->xpc_private_key)) {
            $failed |= static::XPC_SYSERR_PRIVKEY;
        }

        // Check private key password
        if (empty($config->xpc_private_key_password)) {
            $failed |= static::XPC_SYSERR_PRIVKEYPASS;
        }

        return $failed;
    }

    /**
     * Check module requirements
     *
     * @return integer
     */
    public function checkRequirements()
    {
        $code = 0;

        if (!function_exists('curl_init')) {
            $code = $code | static::REQ_CURL;
        }

        if (
            !function_exists('openssl_pkey_get_public') || !function_exists('openssl_public_encrypt')
            || !function_exists('openssl_get_privatekey') || !function_exists('openssl_private_decrypt')
            || !function_exists('openssl_free_key')
        ) {
            $code = $code | static::REQ_OPENSSL;
        }

        if (!class_exists('DOMDocument')) {
            $code = $code | static::REQ_DOM;
        }

        return $code;
    }

    /**
     * Log error
     *
     * @param string $msg Error message
     *
     * @return void 
     */
    protected static function writeLogError($msg)
    {
        \XLite\Logger::getInstance()->logCustom(self::LOG_FILE_ERROR, $msg);
    }

    /**
     * Get API request
     *
     * @param array $data
     *
     * @return sting
     */
    public function getApiRequest()
    {
        return $this->apiRequest;
    }

    /**
     * Wrapper for encryption of the response
     *
     * @param string $data
     *
     * @return array
     */
    public function processApiResponse($data)
    {
        return $this->apiRequest->processApiResponse($data);
    }

    /**
     * Wrapper for decryption of the response
     *
     * @param array $data
     *
     * @return sting
     */
    public function encryptRequest($data)
    {
        $xml = $this->apiRequest->convertHashToXml($data);
        return $this->apiRequest->encryptXml($xml);
    }

    /**
     * Constructor
     *
     * @return void 
     */
    public function __construct()
    {
        parent::__construct();

        $this->apiRequest = new \XLite\Module\CDev\XPaymentsConnector\Core\ApiRequest;
    }
}
