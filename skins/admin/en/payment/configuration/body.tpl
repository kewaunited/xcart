{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment configuration
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="payment-conf">

{if:hasPaymentModules()}
  <div IF="hasGateways()" class="box gateways">
    <h2>{t(#Online methods#)}</h2>
    <widget class="XLite\View\Button\Payment\AddMethod" paymentType={%\XLite\Model\Payment\Method::TYPE_ALLINONE%} style="add-method top-button-add-method" />
    <div class="content">

      {if:hasAddedGateways()}
      <widget class="XLite\View\ItemsList\Payment\Method\Admin\Gateways" />
      {else:}
      {end:}

      {if:hasAddedAlternative()}
      <widget class="XLite\View\ItemsList\Payment\Method\Admin\Alternative" />
      {else:}
      {end:}

    </div>
  </div>
{else:}
  <div class="box no-payment-modules">
    <h2>{t(#No payment modules installed#)}</h2>
    <div class="content">
      <p>{t(#In order to accept credit cards payments you should install the necessary payment module from our Marketplace.#)}</p>
      <widget class="XLite\View\Button\Link" label="{t(#Go to Marketplace#)}" location="{buildURL(#addons_list_marketplace#,##,_ARRAY_(#tag#^#Payment processing#))}" style="action" />
    </div>
  </div>
{end:}
  <div class="right-panel-payment-modules">

    <div IF="hasPaymentModules()" class="subbox marketplace">
      <h2>{t(#Need more payment methods?#)}</h2>

      <img src="images/payment_logos.gif" alt="{t(#Payment methods#)}" class="payment-logos" /><br />

      <widget class="XLite\View\Button\Link" label="{t(#Find in Marketplace#)}" location="{buildURL(#addons_list_marketplace#,##,_ARRAY_(#tag#^#Payment processing#))}" style="regular-main-button" />
    </div>

    <div class="subbox watch-video">
      <h2>{t(#Understanding Online Payments#)}</h2>
      <p>{t(#Watch this short video and learn the basics of how online payment processing works#)}</p>
      <widget class="XLite\View\Button\Link" label="{t(#Watch video#)}" location="{getVideoURL()}" style="watch-video" blank="true" />
    </div>

  </div>

  <div class="box offline-methods">
  <h2>{t(#Offline methods#)}</h2>
  <widget class="XLite\View\Button\Payment\AddMethod" paymentType={%\XLite\Model\Payment\Method::TYPE_OFFLINE%} style="add-method top-button-add-method" />
  <div class="content">
    <widget class="XLite\View\ItemsList\Payment\Method\Admin\OfflineModules" />
    <widget class="XLite\View\ItemsList\Payment\Method\Admin\Offline" />
  </div>
</div>

</div>
