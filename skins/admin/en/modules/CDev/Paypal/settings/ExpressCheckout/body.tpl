{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Payment\MethodStatus" />

<div class="payment-settings {paymentMethod.getServiceName()}">

  <div class="middle">

    <widget class="\XLite\Module\CDev\Paypal\View\Model\ExpressCheckout" paymentMethod="{getPaymentMethod()}" />

    <div class="help">
      <div class="logo-ppec"></div>

      <div class="help-title">Let Your Customers Pay with PayPal</div>

      <div class="help-text">
        Add PayPal as a payment method to your checkout page or use it as a stand-alone solution. You'll open the door to over 100 million active PayPal customers who look for and use this fast, easy, and secure way to pay.
      </div>

      <div class="links">
        <div class="help-link">Don't have an account?

          {if:isInContextSignUpAvailable()}
          <a href="{getSignUpUrl()}" target="PPFrame" data-paypal-button="true">Sign Up Now</a>
          {else:}
          <span class="external"><a href="{getSignUpUrl()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span>
          {end:}

        </div>
        <div class="help-link">Need instructions? <span class="external"><a href="{paymentMethod.getKnowledgeBasePageURL()}" target="_blank">Show</a> <i class="icon fa fa-external-link"></i></span></div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getPartnerPageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
