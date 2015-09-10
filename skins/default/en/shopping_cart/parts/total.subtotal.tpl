{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.totals", weight="10")
 * @ListChild (list="cart.panel.totals", weight="10")
 *}
<li class="subtotal">
  <strong>{t(#Subtotal#)}:</strong>
  <span class="cart-subtotal">
    <widget class="XLite\View\Surcharge" surcharge="{cart.getDisplaySubtotal()}" currency="{cart.getCurrency()}" />
  </span>
</li>
