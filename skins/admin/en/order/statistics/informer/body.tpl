{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order summary mini informer (for dashboard)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="order-statistics-mini-informer collapsed">
  <div class="header">
    {getSVGImage(#images/statistics.svg#):h}
    {t(#Sale statistics#)}
    <i class="fa fa-angle-down"></i>
    <i class="fa fa-angle-right"></i>
  </div>
  <div class="content">
    {foreach:getTabs(),tab}
    <widget template="{tab.template}" />
    {end:}
  </div>
</div>
