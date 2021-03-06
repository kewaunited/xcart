{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.base.totals", weight="100")
 *}

<li class="subtotal">
  <div class="title">{t(#Subtotal#)}:</div>
  <div class="value">{formatPriceHTML(order.getSubtotal(),order.getCurrency()):h}</div>
</li>
