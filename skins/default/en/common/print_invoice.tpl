{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Printable invoices
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{foreach:getOrders(),i,order}
<div{if:hasPageBreak(i)} class="page-break"{end:}>
  <widget class="\XLite\View\Invoice" order="{order}" />
</div>
{end:}
