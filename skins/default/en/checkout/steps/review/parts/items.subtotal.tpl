{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : order review step : items : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="checkout.review.selected.items", weight="10")
 * @ListChild (list="checkout.review.inactive.items", weight="10")
 *}
<div class="items-row clearfix">
  <a href="#">{t(#X items in bag#,_ARRAY_(#count#^cart.countQuantity())):h}</a>
  <span class="price">
    <widget class="XLite\View\Surcharge" surcharge="{cart.getDisplaySubtotal()}" currency="{cart.getCurrency()}" />
  </span>
</div>