{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="payment-settings {paymentMethod.getServiceName()}">

  <div class="middle">

    <widget class="\XLite\Module\CDev\Paypal\View\Model\PaypalCredit" paymentMethod="{getPaymentMethod()}" />


    <div class="help">
      <div class="logo-pc"></div>

      <div class="help-title">Give your sales a boost when you advertise financing</div>

      <div class="help-text">
        PayPal helps turn browsers into buyers with financing from Paypal Credit&reg;. Your customers have more time to pay, while you get paid up front — at no additional cost to you.
      </div>

      <div class="help-text">
        Use PayPal’s free banner ads that let you advertise Paypal Credit&reg;
          <widget class="\XLite\View\Tooltip" isImageTag="false" caption="financing" text="Applicable for qualifying purchases of $99 or more if paid in full within 6 months. Customers check out with PayPal and use Bill Me Later. Bill Me Later is subject to consumer credit approval, as determined by the lender, Comenity Capital Bank." />
        as a payment option when your customers check out with PayPal. Many merchants who advertise financing see an average 20% increase in their
          <widget class="\XLite\View\Tooltip" isImageTag="false" caption="online sales" text="Based on a comparable year-over-year online sales study of 118 merchants who used Bill Me Later promotional financing banners starting in October 2012 (PayPal study, 11/12-12/12)." />
        .
      </div>

      <div class="links">
        <div class="help-link">Don't have an account? <span class="external"><a href="{paymentMethod.getReferralPageURL()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span></div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getKnowledgeBasePageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
