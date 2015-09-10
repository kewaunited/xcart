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
 * Zero-dollar authorization (card setup)
 *
 */
class ZeroAuth extends \XLite\Base\Singleton
{
    /**
     * This is a key for the Do not use card setup option
     */
    const DISABLED = -1;

    /**
     * Get config
     *
     * @return object
     */
	protected static function getConfig()
	{
		return \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;
	}

    /**
     * Get X-Payments client 
     *
     * @return object
     */
	protected static function getClient()
	{
		return \XLite\Module\CDev\XPaymentsConnector\Core\XPaymentsClient::getInstance();
	}

    /**
     * Get payment method for zero-auth (card setup)
     *
     * @return \XLite\Model\Payment\Method
     */
    public function allowZeroAuth()
    {
        return self::DISABLED != $this->getConfig()->xpc_zero_auth_method_id
            && $this->getPaymentMethod();
    }

    /**
     * Get list of payment methods which allow to save cards and are marked by admin so
     *
     * @param $resultAsTitle Return values as method titles or as objects
     *
     * @return array
     */
    public function getCanSaveCardsMethods($resultAsTitle = false)
    {
        static $list = null; 

        if (is_null($list)) {

            $list = array();

            $paymentMethods = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findAllActive();

            foreach ($paymentMethods as $pm) {
                if (
                    'Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments' == $pm->getClass()
                    && 'Y' == $pm->getSetting('saveCards')
                ) {
                    $list[$pm->getMethodId()] = $resultAsTitle ? $pm->getTitle() : $pm;
                }
            }
        }

        return $list;
    }

    /**
     * Get payment method for zero-auth (card setup)
     *
     * @return \XLite\Model\Payment\Method
     */
    public function getPaymentMethod()
    {
        $methods = $this->getCanSaveCardsMethods();

        return array_key_exists($this->getConfig()->xpc_zero_auth_method_id, $methods)
            ? $methods[$this->getConfig()->xpc_zero_auth_method_id]
            : null;
    }

    /**
     * Get customer profile
     *
     * @return \XLite\Model\Profile
     */
    protected function detectProfile()
    {
        $profile = null;

        if (\XLite\Core\Request::getInstance()->xpcBackReference) {
            $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')
                ->findOneBy(array('pending_zero_auth' => \XLite\Core\Request::getInstance()->xpcBackReference));
        }

        return $profile;
    }

    /**
     * Get customer profile
     *
     * @return \XLite\Model\Profile
     */
    protected function detectTransaction()
    {
        $transaction = null;

        $transactionData = \XLite\Core\Database::getRepo('XLite\Model\Payment\TransactionData')
            ->findOneBy(array('value' => \XLite\Core\Request::getInstance()->xpcBackReference, 'name' => 'xpcBackReference'));

        if ($transactionData) {
            $transaction = $transactionData->getTransaction();
        } 

        return $transaction;
    }

    /**
     * Default description for Card setup
     *
     * @return string
     */
    public static function getDefaultDescription()
    {
        return \XLite\Core\Translation::lbl('Card setup');
    }

    /**
     * Create cart 
     *
     * @return \XLite\Model\Cart 
     */
    protected function createCart(\XLite\Model\Profile $profile)
    {
        $cart = $this->getClient()->createFakeCart(
            $profile,
            $this->getPaymentMethod(),
            $this->getClient()->getCurrencyForPaymentMethod($this->getPaymentMethod()),
            $this->getConfig()->xpc_zero_auth_amount,
            $this->getConfig()->xpc_zero_auth_description
                ? $this->getConfig()->xpc_zero_auth_description
                : self::getDefaultDescription(),
            'CardSetup'
        );

        return $cart;
    }

    /**
     * Prepare cart hash to send to X-Payments
     *
     * @return array
     */
    protected function getPreparedCart(\XLite\Model\Cart $cart)
    {
        return $this->getClient()->prepareCart($cart, $this->getPaymentMethod(), null, true, true);
    }

    /**
     * Get iframe URL
     *
     * @return string
     */
    public function getIframeUrl(\XLite\Model\Profile $profile, $interface = \XLite::CART_SELF)
    {
        $iframeUrl = false;

        // Prepare cart
        $cart = $this->createCart($profile);
        $preparedCart = $this->getPreparedCart($cart);

        if ($preparedCart) {

            $xpcBackReference = md5(time() . 'CardSetup');

            $transaction = $cart->getFirstOpenPaymentTransaction();

            $this->getPaymentMethod()->getProcessor()->savePaymentSettingsToTransaction($transaction);

            $profile->setPendingZeroAuth($xpcBackReference);
            $profile->setPendingZeroAuthInterface($interface);
            \XLite\Core\Database::getEM()->flush();

            // Data to send to X-Payments
            $data = array(
                'confId'      => intval($this->getPaymentMethod()->getSetting('id')),
                'refId'       => $xpcBackReference,
                'cart'        => $preparedCart,
                'language'    => 'en',
                'returnUrl'   => $this->getClient()->getReturnUrl($xpcBackReference, true),
                'callbackUrl' => $this->getClient()->getCallbackUrl($xpcBackReference, true),
            );

            // For API v1.3 and higher we can send the template for iframe
            if (version_compare($this->getConfig()->xpc_api_version, '1.3') >= 0) {

                $data += array(
                    'saveCard'    => 'Y',
                    'template'    => 'xc5',
                );
            }

            $init = $this->getClient()->getApiRequest()->send(
                'payment',
                'init',
                $data
            );

			if ($init->isSuccess()) {

                $response = $init->getResponse();

	            $iframeUrl = $this->getConfig()->xpc_xpayments_url . '/payment.php?target=main&token=' . $response['token'];

                $transaction->setDataCell('xpc_txnid', $response['txnId'], 'X-Payments transaction id', 'C');
                $transaction->setDataCell('xpcBackReference', $xpcBackReference, 'X-Payments back reference', 'C');

                // AntiFraud service
                if (method_exists($transaction, 'processAntiFraudCheck')) {
                    $transaction->processAntiFraudCheck();
                }

                \XLite\Core\Database::getEM()->flush();

			} else {

                throw new \Exception($init->getError());

            }

        }

        return $iframeUrl;
    }

    /**
     * JS code to redirect back to saved cards page
     *
     * @return string 
     */
    protected function getRediectCode(\XLite\Model\Profile $profile)
    {
        $url = \XLite::getInstance()->getShopUrl(
                \XLite\Core\Converter::buildUrl(
                    'saved_cards', 
                    '', 
                    array('profile_id' => $profile->getProfileId()),
                    $profile->getPendingZeroAuthInterface()
                )
            );

        return '<script type="text/javascript">'
			. 'window.parent.location = "' . $url . '";'
			. '</script>';
    }

    /**
     * Cleanup pending zero-auth data from profile 
     *
     * @return void
     */
    protected function cleanupZeroAuthPendingData(\XLite\Model\Profile $profile)
    {
        $profile->setPendingZeroAuthTxnId('');
        $profile->setPendingZeroAuth('');
        $profile->setPendingZeroAuthInterface('');

        \XLite\Core\Database::getEM()->flush();
    }

    /**
     * Return action
     *
     * @return void
     */
    public function doActionReturn()
    {
        $profile = $this->detectProfile();
        $transaction = $this->detectTransaction();

        if (
            $profile
            && $transaction
        ) {

            $status = $transaction->getOrder()->getPaymentStatus()->getCode();

            $request = \XLite\Core\Request::getInstance();

            if (
                $request->last_4_cc_num
                && $request->card_type
                && !$transaction->getCard()
            ) {
                $transaction->saveCard('******', $request->last_4_cc_num, $request->card_type);
            }

            if (in_array($status, \XLite\Model\Order\Status\Payment::getPaidStatuses())) {

                $transaction->getXpcData()->setUseForRecharges('Y');

                \XLite\Core\TopMessage::addInfo('Card saved');

            } else {

                \XLite\Core\TopMessage::addError('Card was not saved due to payment processor error');
            }

            \XLite\Core\Database::getEM()->flush();

            echo $this->getRediectCode($profile);

            // Cleanup pending zero-auth data
            $this->cleanupZeroAuthPendingData($profile);

            // Cleanup fake carts from session
            self::cleanupFakeCarts($profile);

            exit;


        } else {

            die('Error occured when saving card. Customer profile not found');
            // Just in case show error inside iframe. However this should not happen

        }

	}

    /**
     * Cleanup fake carts from session
     *
     * @return void
     */
    public static function cleanupFakeCarts(\XLite\Model\Profile $profile)
    {
        $carts = \XLite\Core\Database::getRepo('XLite\Model\Cart')->findByProfile($profile);

        foreach ($carts as $cart) {

            // Fake cart contains only one item, but there is no first() method
            $item = $cart->getItems()->last();

            if (
                $item
                && $item->isXpcFakeItem()
            ) {
                \XLite\Core\Database::getEM()->remove($cart);
            }

        }

        \XLite\Core\Database::getEM()->flush();    
    }
}
