{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list widget for popup
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
        
<ul>
  <li class="payment-logo">
  {if:payment.getAdminIconURL()}
    <img src="{payment.getAdminIconURL()}" alt="{payment.getTitle()}" />
  {else:}
    <img IF="payment.getIconURL()" src="{payment.getIconURL()}" alt="{payment.getTitle()}" />
  {end:}
   </li>
   <li class="title">{payment.getName()}</li>
   <li class="actions">
    <div class="separator"></div>
    <div {if:payment.getAdded()}class="switcher enabled" title="{t(#Payment method has been added#)}"{else:}class="switcher disabled" title="{t(#Payment method was not added#)}"{end:}>
      <i class="fa fa-check-circle"></i>
    </div>
    <div class="separator"></div>
    <div class="button">
    <widget
      IF="payment.getModuleEnabled()&!payment.getAdded()"
      class="XLite\View\Button\Link"
      label="{t(#Add#)}"
      location="{buildURL(#payment_settings#,#add#,_ARRAY_(#id#^payment.getMethodId()))}" />
    <widget
      IF="payment.getAdded()"
      class="XLite\View\Button\Link"
      label="{t(#Settings#)}"
      location="{buildURL(#payment_settings#,#add#,_ARRAY_(#id#^payment.getMethodId()))}" />
    <widget
      IF="isDisplayInstallModuleLink(payment)"
      class="XLite\View\Button\Link"
      label="{t(#Install#)}"
      location="{getPaymentModuleURL(payment)}"
      style="regular-main-button install-link" />
    <widget
      IF="isDisplayInstallModuleButton(payment)"
      class="XLite\View\Button\Addon\Install"
      moduleId="{payment.getModuleId()}"
      paymentMethodId="{payment.getMethodId()}"
      style="regular-main-button install"
      jsConfirmText="{t(#System will download and install this module from marketplace. Continue?#)}"
       />
    </div>
  </li>
</ul>
