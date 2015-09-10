{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifiers
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.base.totals", weight="200")
 *}

{foreach:getSurchargeTotals(),sType,surcharge}
  <li {printTagAttributes(getSurchargeAttributes(sType,surcharge)):h}>
    <widget class="{surcharge.widget}" surcharge="{surcharge}" sType="{sType}" order="{order}" />
  </li>
{end:}
