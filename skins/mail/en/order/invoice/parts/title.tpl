{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice title
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base", weight="20")
 *}

<widget template="order/invoice/parts/title.invoice.tpl" />
<div style="color: #333333;font-size: 20px;padding-left: 3px;padding-top: 1px;width: 100%;max-width: 700px;">
  {formatTime(order.getDate())}
  <span style="float: right; color: #000;font-size: 20px;font-weight: bold;">{t(#Grand total#)}: {formatInvoicePrice(order.getTotal(),order.getCurrency(),1)}</span>
</div>
