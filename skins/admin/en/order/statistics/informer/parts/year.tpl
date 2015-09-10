{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order summary mini informer (for dashboard)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="order-statistics {tab.class}">
  <div class="revenue">
    <span class="label">{t(#Year#)}:</span>
    <span class="value">{formatPrice(tab.revenue.value)}</span>
  </div>
  <div class="orders">
    <span class="label">/</span>
    <span class="value">{tab.orders.value}</span>
  </div>
  <div class="dynamic-icon {getRevenueClass(tab)}">{getIcon(tab):h}</div>
  <div IF="showPrevious(tab)" class="previous">
    <span class="label">{t(#Last year#)}</span>
    <span class="value">{formatPrice(tab.revenue.prev)}</span>
    <span class="separator">/</span>
    <span class="value">{tab.orders.prev}</span>
  </div>
</div>