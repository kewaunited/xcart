{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add payment type widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="add-payment-box payment-type-{getPaymentType()}">

  {* Online methods list *}
  <div IF="!%\XLite\Model\Payment\Method::TYPE_OFFLINE%=getPaymentType()" class="tabs-container">

    <div class="page-tabs">
      <ul>
        <li class="tab tab-current payment-gateways selected">{t(#Payment gateways#):h}</li>
        <li class="tab all-in-one-solutions">{t(#PayPal all-in-one solutions#):h}</li>
      </ul>
    </div>

    <div class="tab-content">
      <ul>
        <li class="body-item payment-gateways selected">
          <div class="body-box">
            <div class="small-head">{t(#Requires registered merchant account#):h}</div>
            <widget class="\XLite\View\SearchPanel\Payment\Admin\Main" />
            <widget class="\XLite\View\ItemsList\Model\Payment\OnlineMethods" />
          </div>
        </li>
        <li class="body-item all-in-one-solutions">
          <div class="body-box">
            <div class="small-head">{t(#No merchant account required. Simple onboarding for you and easy checkout for your customers.#)}</div>
            <widget class="\XLite\View\Payment\MethodsPopupList" paymentType="{_ARRAY_(%\XLite\Model\Payment\Method::TYPE_ALLINONE%)}" />
          </div>
        </li>
      </ul>
    </div>

  </div>

  {* Offline methods list *}
  <ul IF="%\XLite\Model\Payment\Method::TYPE_OFFLINE%=getPaymentType()" class="offline-methods tabs-container">
    <li class="offline selected tab">
      <ul>
        <li class="body">
          <list name="payment.method.add.offline" />
        </li>
      </ul>
    </li>
  </ul>

</div>
