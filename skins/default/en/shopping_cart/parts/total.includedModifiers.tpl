{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.totals", weight="30")
 * @ListChild (list="cart.panel.totals", weight="30")
 *}

{if:cart.getItemsIncludeSurchargesTotals()}  
  <li class='included-surcharge' FOREACH="cart.getItemsIncludeSurchargesTotals(),row">
    <strong>{t(#Including X#,_ARRAY_(#name#^row.surcharge.getName()))}:</strong>
    <span class="value"><widget class="XLite\View\Surcharge" surcharge="{row.surcharge.getValue()}" currency="{cart.getCurrency()}" />
  </li>
{end:}
