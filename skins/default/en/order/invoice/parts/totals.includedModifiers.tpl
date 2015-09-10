{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="300")
 *}
{if:order.getItemsIncludeSurchargesTotals()}  
    <li class='included-surcharge' FOREACH="order.getItemsIncludeSurchargesTotals(),row">
      <span class="name">{t(#Including X#,_ARRAY_(#name#^row.surcharge.getName()))}:</span>
      <span class="value"><widget class="XLite\View\Surcharge" surcharge="{row.cost}" currency="{order.getCurrency()}" />
    </li>
{end:}
