{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : order review step : items : paid
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="checkout.review.selected.items", weight="50")
 * @ListChild (list="checkout.review.inactive.items", weight="50")
 *}
<div class="paid clearfix" IF="isPartiallyPaid()">
  {t(#Paid#)}:
  <span class="value"><widget class="XLite\View\Surcharge" surcharge="{cart.getPaidTotal()}" currency="{cart.getCurrency()}" /></span>
</div>
