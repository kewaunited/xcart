{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item name cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="item-name">
  <a IF="entity.getURL()" href="{entity.getURL()}" class="item-name">{getColumnValue(column,entity)}</a>
  <span IF="!entity.getURL()" class="item-name">{getColumnValue(column,entity)}</span>
  <span IF="!entity.product.isPersistent()" class="deleted-product-note">({t(#deleted#)})</span>
</div>

<ul class="subitem additional simple-list">
  <list name="invoice.item.name" item="{entity}" displayVariative="1" />
</ul>

<widget IF="!isStatic()" class="\XLite\View\OrderItemAttributes" orderItem="{entity}" />
