{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Express checkout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="cart-checkout">
  <a href="{getLocationURL()}" onclick="paypalExpressCheckout(this)" class="{getClass()}"{if:getId()} id="{getId()}"{end:}{if:hasMerchantId()} data-paypal-id="{getMerchantId()}"{end:}>
    <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png" alt="Check out with PayPal" />
  </a>
</div>
