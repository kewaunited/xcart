{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : order review step : items : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="checkout.review.selected.items", weight="40")
 *}

<ul class="modifiers included-modifiers">
  {if:cart.getItemsIncludeSurchargesTotals()}  
    <li class='included-surcharge' FOREACH="cart.getItemsIncludeSurchargesTotals(),row">
      <span class="name">{t(#Including X#,_ARRAY_(#name#^row.surcharge.getName()))}:</span>
      <span class="value"><widget class="XLite\View\Surcharge" surcharge="{row.cost}" currency="{cart.getCurrency()}" />
    </li>
  {end:}
</ul>
