{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifier default template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="title clear-fix">
  {t(#Shipping method / cost#)}:
  <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
</div>

<div class="value">
  {if:surcharge.available}
    <div class="method">
      {orderForm.displayComplexField(#shippingMethod#)}
    </div>
    <div class="separator">&ndash;</div>
    {surcharge.formField.display():h}
    <widget template="order/page/parts/restore.tpl" surcharge="{surcharge}" />
  {else:}
    {t(#n/a#)}
  {end:}
  <list name="order.base.totals.modifier.value" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
</div>
