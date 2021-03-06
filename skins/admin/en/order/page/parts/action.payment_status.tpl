{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment order status selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.actions.statuses", weight="200")
 *}

<div class="status payment-status">
  <widget
    class="\XLite\View\FormField\Select\OrderStatus\Payment"
    label="Payment status"
    fieldName="paymentStatus"
    order="{order}" />
</div>
