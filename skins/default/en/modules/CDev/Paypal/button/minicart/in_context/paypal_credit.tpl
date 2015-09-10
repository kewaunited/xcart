{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Paypal credit
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="cart-checkout">
  <a href="{getLocationURL()}" onclick="paypalExpressCheckout(this)" class="{getClass()}"{if:getId()} id="{getId()}"{end:}{if:hasMerchantId()} data-paypal-id="{getMerchantId()}"{end:}>
    <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/ppcredit-logo-medium.png" alt="PayPal Credit" />
  </a>
  <div>
    <a href="https://www.securecheckout.billmelater.com/paycapture-content/fetch?hash=AU826TU8&content=/bmlweb/ppwpsiw.html" target="_blank">
      <img src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_bml_text.png" />
    </a>
  </div>
</div>
