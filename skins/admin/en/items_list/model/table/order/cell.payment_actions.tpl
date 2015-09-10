{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Cell actions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.orders.search.cell.status")
 *}

<div IF="hasPaymentActions(entity)" class="payment-actions">
  <widget class="\XLite\View\Order\Details\Admin\PaymentActions" order="{entity}" unitsFilter="{getTransactionsFilter()}" />
</div>
