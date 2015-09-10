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

namespace XLite\Module\CDev\XPaymentsConnector\Controller\Customer;

/**
 * Checkout 
 *
 */
abstract class Checkout extends \XLite\Module\CDev\ProductAdvisor\Controller\Customer\Checkout implements \XLite\Base\IDecorator
{

    /**
     * Public wrapper for check checkout action
     *
     * @return void
     */
    public function isCheckoutReady()
    {
        return $this->getCart() 
            && $this->getCart()->getProfile() 
            && $this->getCart()->getProfile()->getLogin()
            && (
                $this->getCart()->getProfile()->getBillingAddress()
                || (
                    $this->getCart()->getProfile()->getShippingAddress()
                    && $this->getCart()->getProfile()->getShippingAddress()->isCompleted(\XLite\Model\Address::SHIPPING)
                )
            );
    }

    /**
     * Checkout. Recognize iframe and save that 
     *
     * @return void
     */
    public function handleRequest()
    {

        if (
            'checkout' == \XLite\Core\Request::getInstance()->action
            && !\XLite\Core\Request::getInstance()->xpc_iframe
        ) {

            \XLite\Core\Session::getInstance()->cardSavedAtCheckout = \XLite\Core\Request::getInstance()->save_card;

        } elseif (
            \XLite\Core\Request::getInstance()->xpc_iframe
            && 'checkout' == \XLite\Core\Request::getInstance()->action
        ) {

            // Enable iframe
            $this->getIframe()->enable();

            // If checkout is not ready finalize the iframe
            if (
                !$this->isCheckoutReady()
                || !$this->checkCheckoutAction()
            ) {
                $this->getIframe()->setError('');
                $this->getIframe()->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_DO_NOTHING);
                $this->getIframe()->finalize();
            }
           
            // It's not initialized yet
            $this->initialCartFingerprint = $this->getCart()->getEventFingerprint();
 
            // Update cart and just in case check the items.
            // Copy-pasted from \XLite\Controller\Customer::doActionCheckout()
            $itemsBeforeUpdate = $this->getCart()->getItemsFingerprint();
            $this->updateCart();
            $itemsAfterUpdate = $this->getCart()->getItemsFingerprint();

            if (
                $this->get('absence_of_product')
                || $this->getCart()->isEmpty()
                || $itemsAfterUpdate != $itemsBeforeUpdate
            ) {
                // Cart is changed
                $this->set('absence_of_product', true);
                $this->setReturnUrl($this->buildURL('cart'));
                $this->getIframe()->setError('Cart changed...');
                $this->getIframe()->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_ALERT);
                $this->getIframe()->finalize();
            }

            $transaction = $this->getCart()->getFirstOpenPaymentTransaction();

            $class = 'Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments';
            if (
                !$transaction
                || !$transaction->getPaymentMethod()
                || $class != $transaction->getPaymentMethod()->getClass()
            ) {
                // Action Checkout with "xpc_iframe" parameter was called.
                // But open transaction was not found, or a different processor is used
                // So exit.
                print ('DEBUG. No transaction...');
                die (0);
            }

        }

        parent::handleRequest();
    }

    /**
     * Show save card checkbox on checkout 
     *
     * @return void
     */
    public function showSaveCardBox() 
    {
        $showToUser = !$this->isAnonymous() && $this->isLogged()
            || \XLite\Core\Session::getInstance()->order_create_profile;

        $showForPayment = $this->getCart()
            && $this->getCart()->getPaymentMethod()
            && 'Y' == $this->getCart()->getPaymentMethod()->getSetting('saveCards');

        return $showToUser && $showForPayment;
    }

    /**
     * Get payment method id
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return ($this->getCart() && $this->getCart()->getPaymentMethod())
            ? $this->getCart()->getPaymentMethod()->getMethodId()
            : 0;
    }

    /**
     * Order placement is success
     *
     * @param boolean $fullProcess Full process or not OPTIONAL
     *
     * @return void
     */
    public function processSucceed($fullProcess = true)
    {
        if (!\XLite\Core\Session::getInstance()->xpc_skip_process_success) {
            parent::processSucceed($fullProcess);
        } else {
            parent::processSucceed(false);
            \XLite\Core\Session::getInstance()->xpc_skip_process_success = null;
        }
    }

    /**
     * Get X-Payments payment methods ids
     *
     * @return array
     */
    public function getXpcPaymentIds()
    {
        $result = array();

        if ($this->getCart() && $this->getCart()->getPaymentMethods()) {
            foreach ($this->getCart()->getPaymentMethods() as $pm) {
                if ($pm->getClass() == 'Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments') {
                    $result[] = $pm->getMethodId();
                }
            }
        }

        return $result;
    }

    /**
     * Save data of the checkout form (notes and flag to save card)
     *
     * @return void
     */
    protected function doActionSaveCheckoutFormData()
    {
        if (\XLite\Core\Request::getInstance()->notes) {
            $this->getCart()->setNotes(\XLite\Core\Request::getInstance()->notes);
        }

        if ('Y' == \XLite\Core\Request::getInstance()->save_card) {
            \XLite\Core\Session::getInstance()->cardSavedAtCheckout = 'Y';
        } else {
            \XLite\Core\Session::getInstance()->cardSavedAtCheckout = 'N';
        }

        \XLite\Core\Database::getEM()->flush();

    }

    /**
     * Clear init data from session and redirrcet back to checkout
     *
     * @return void
     */
    protected function doActionClearInitData()
    {
        \XLite\Module\CDev\XPaymentsConnector\Core\XPaymentsClient::getInstance()->clearInitDataFromSession();

        $this->setHardRedirect();
        $this->setReturnURL($this->buildURL('cart', 'checkout'));
        $this->doRedirect();
    }

    /**
     * Return from payment gateway
     *
     * @return void
     */
    protected function doActionReturn()
    {
        $orderId = \XLite\Core\Request::getInstance()->order_id;
        $order = \XLite\Core\Database::getRepo('XLite\Model\Order')->find($orderId);

        if ($order) {

            // Set customer notes 
            if (!empty(\XLite\Core\Request::getInstance()->notes)) {
                $order->setNotes(\XLite\Core\Request::getInstance()->notes);
            }

            // Mark card as allowed for further recharges
            if (
                'Y' == \XLite\Core\Request::getInstance()->save_card
                || 'Y' == \XLite\Core\Session::getInstance()->cardSavedAtCheckout
            ) {

                $useForRecharges = 'Y';
                \XLite\Core\Session::getInstance()->cardSavedAtCheckout = 'N';

            } else {

                $useForRecharges = 'N';
            }

            foreach ($order->getPaymentTransactions() as $transaction) {

                if ($transaction->getXpcData()) {
                    $transaction->getXpcData()->setUseForRecharges($useForRecharges);
                }
            }

            \XLite\Core\Database::getEM()->flush();

            if (
                \XLite\Core\Session::getInstance()->xpc_order_create_profile
                && !($order instanceof \XLite\Model\Cart)
            ) {

                // For successfully placed orders only

                if ($order->getProfile()) {

                    \XLite\Core\Auth::getInstance()->loginProfile($order->getProfile());

                } elseif ($order->getOrigProfile()) {

                    \XLite\Core\Auth::getInstance()->loginProfile($order->getOrigProfile());
                }
            }
        }

        parent::doActionReturn();

        if ($order) {

            $transactions = $order->getPaymentTransactions();

            $lastTransaction = $transactions->first();

            if ($lastTransaction->isXpc()) {
                $order->setPaymentStatusByTransaction($lastTransaction);

                $lastTransaction->setDataCell('xpc_session_id', '', null, 'C');

                \XLite\Core\Database::getEM()->flush();
            }
        }
    }

    /**
     * Get class name for save card box 
     *
     * @return string 
     */
    public function getSaveCardBoxClass()
    {
        return \XLite\Core\Request::getInstance()->xpc_iframe
            ? 'save-card-box'
            : 'save-card-box-no-iframe';

    }

    /**
     * Update profile
     *
     * @return void
     */
    protected function doActionUpdateProfile()
    {
        parent::doActionUpdateProfile();

        $showSaveCardBox = $this->showSaveCardBox()
            ? 'Y'
            : 'N';

        $checkCheckoutAction = $this->checkCheckoutAction()
            ? 'Y'
            : 'N';

        \XLite\Core\Event::xpcEvent(
            array(
                'showSaveCardBox' => $showSaveCardBox,
                'checkCheckoutAction' => $checkCheckoutAction
            )
        );
    }
}
