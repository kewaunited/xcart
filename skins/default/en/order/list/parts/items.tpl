{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list items block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.children", weight="20")
 *}
<ul IF="getPageData()" class="list">
  <li FOREACH="getPageData(),order" class="order-{order.order_id}">
    <widget class="\XLite\View\OrderList\OrderListItem" order="{order}" />
  </li>
</ul>
