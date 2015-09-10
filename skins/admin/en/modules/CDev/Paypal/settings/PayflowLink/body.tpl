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

    <widget class="\XLite\Module\CDev\Paypal\View\Model\PayflowLink" paymentMethod="{getPaymentMethod()}" />

    <div class="help">
      <div class="logo-pfl"></div>

      <div class="help-title">Accept Payments with Your Merchant Account</div>

      <div class="help-text">Accept Visa, MasterCard&reg;, American Express, Discover and PayPal payments on your site by connecting a PayPal-hosted checkout page with your own internet merchant account. Customize the page to look like the rest of your site and make sure customer transactions are secure.
      </div>

      <div class="links">
        <div class="help-link">Don't have an account? <span class="external"><a href="{paymentMethod.getReferralPageURL()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span></div>
        <div class="help-link">Need instructions? <span class="external"><a href="{paymentMethod.getKnowledgeBasePageURL()}" target="_blank">Show</a> <i class="icon fa fa-external-link"></i></span></div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getPartnerPageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
