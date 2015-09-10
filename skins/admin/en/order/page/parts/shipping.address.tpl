{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order's shipping address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.shipping", weight="200")
 *}
<div class="address" IF="isShippingAddressVisible()">
  <strong>{t(#Shipping address#)}</strong>

  <div class="address-section shipping-address-section">{orderForm.displayComplexField(#shippingAddress#)}</div>
</div>
