{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="100")
 *}
<li>
    <div class="title">{t(#Subtotal#)}:</div>
    <div class="value">{formatInvoicePrice(order.getDisplaySubtotal(),order.getCurrency(),1)}</div>
</li>
