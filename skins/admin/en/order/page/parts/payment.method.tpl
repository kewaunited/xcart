{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order's payment method
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.payment", weight="100")
 *}

<div class="method">
  <ul>
    {if:orderForm.getComplexField(#paymentMethods#)}
      <li FOREACH="orderForm.getComplexField(#paymentMethods#),w">{w.display()}</li>
    {elseif:order.getPaymentMethodName()}
      <li class="method-name">{t(order.getPaymentMethodName()):h}</li>
    {else:}
      <li class="method-name">{t(#n/a#)}</li>
    {end:}
  </ul>
</div>
