{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifier default template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:surcharge.count=#1#}

  <div class="title">
    {surcharge.lastName}:
    <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
  </div>

{else:}

  <div class="title list-owner">
    {surcharge.name}:
    <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
  </div>

{end:}

<div class="value">
  {if:surcharge.available}
    {surcharge.formField.display():h}
    <widget template="order/page/parts/restore.tpl" surcharge="{surcharge}" />
  {else:}
    {t(#n/a#)}
  {end:}
  <list name="order.base.totals.modifier.value" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
</div>
