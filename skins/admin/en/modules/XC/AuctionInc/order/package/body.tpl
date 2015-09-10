{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Package detail
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="package">
  <h2>{t(#Package#)} {getIndex()}</h2>
  <div class="package-info">
    <ul class="fields">
      <li FOREACH="getPackageFields(),field,value">
        <span class="field"><strong>{field}</strong></span>
        <span class="value">{value}</span>
      </li>
    </ul>

    <ul class="items">
      <li class="header">
        <span class="name">{t(#Name#)}</span>
        <span class="qry">{t(#Quantity#)}</span>
        <span class="weight">{t(#Weight#)}</span>
      </li>

      <li FOREACH="getPackageItems(),item">
        <span IF="item.item" class="name">
          <a IF="item.item.getUrl()" href="{item.item.getUrl()}" class="item-name">{item.item.name}</a>
          <span IF="!item.item.getUrl()" class="item-name">{item.item.name}</span>
        </span>
        <span IF="!item.item" class="name">
          <span class="item-name">{item.sku}</span>
        </span>
        <span class="qry">{item.qty}</span>
        <span class="weight">{item.weight}</span>
      </li>
    </ul>
  </div>
</div>
