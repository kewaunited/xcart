{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order's billing address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.payment", weight="200")
 *}

<div class="address" IF="isBillingAddressVisible()">
  <strong>{t(#Billing address#)}</strong>

  <div class="address-section payment-address-section">{orderForm.displayComplexField(#billingAddress#)}</div>
</div>
