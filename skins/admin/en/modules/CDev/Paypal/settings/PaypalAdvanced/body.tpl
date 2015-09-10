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

    <widget class="\XLite\Module\CDev\Paypal\View\Model\PaypalAdvanced" paymentMethod="{getPaymentMethod()}" />

    <div class="help">
      <div class="logo-ppa"></div>

      <div class="help-title">Accept Payments Directly on Your Site</div>

      <div class="help-text">Accept Visa, MasterCard&reg;, American Express, Discover, and PayPal payments. Customers stay on your site for the entire checkout process with this all-in-one option. It simplifies PCI compliance and opens the door to more than 100 million active PayPal customers. Requires credit approval (2-3 business days).
      </div>

      <div class="links">
        <div class="help-link">Don't have an account? <span class="external"><a href="{paymentMethod.getReferralPageURL()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span></div>
        <div class="help-link">Need instructions? <span class="external"><a href="{paymentMethod.getKnowledgeBasePageURL()}" target="_blank">Show</a> <i class="icon fa fa-external-link"></i></span></div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getPartnerPageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
