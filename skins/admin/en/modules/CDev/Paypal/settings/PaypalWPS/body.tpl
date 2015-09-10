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

    <widget class="\XLite\Module\CDev\Paypal\View\Model\PaypalWPS" paymentMethod="{getPaymentMethod()}" />

    <div class="help">
      <div class="logo-ppa"></div>

      <div class="help-title">Accept PayPal and Credit Cards Securely</div>

      <div class="help-text">
        Add a PayPal payment button to your site to accept Visa, MasterCard&reg;, American Express, Discover and PayPal payments securely. When your customers check out, they are redirected to PayPal to pay, then return to your site after they are finished.
      </div>

      <div class="links">
        <div class="help-link">Don't have an account? <span class="external"><a href="{paymentMethod.getReferralPageURL()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span></div>
        <div class="help-link">Need instructions? <span class="external"><a href="{paymentMethod.getKnowledgeBasePageURL()}" target="_blank">Show</a> <i class="icon fa fa-external-link"></i></span></div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getPartnerPageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
