{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ORDER_EDIT order history event comment template 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul>
  <li FOREACH="getChanges(),name,data">
    <div class="name">{t(name)}:</div>
    {if:isArray(data)}
    <ul>
      <li FOREACH="data,subname,value">
        <div IF="isDisplaySubname(subname)" class="subname">{t(subname)}:</div>
        <div class="value">{if:value.old}<span class="old">{value.old}</span><i class="fa fa-long-arrow-right"></i>{end:}<span class="new">{value.new}</span></div>
      </li>
    </ul>
    {else:}
    <div class="value">{if:data.old}<span class="old">{data.old}</span><i class="fa fa-long-arrow-right"></i>{end:}<span class="new">{data.new}</span></div>
    {end:}
  </li>
</ul>
