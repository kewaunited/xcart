{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Wholesale prices
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="tooltip-main">
  {if:entity.getDefaultPrice()}
    <img class="tooltip-caption" src="skins/admin/en/modules/CDev/Wholesale/wp2.svg" alt="" height="20" />
  {else:}
  <a href="{getLink()}" class="tooltip-caption">
    <img src="skins/admin/en/modules/CDev/Wholesale/wp.svg" alt="" height="20" />
  </a>
  {end:}
  <div class="help-text" style="display: none;">
    {if:entity.getDefaultPrice()}
    <b>{t(#Set the price for this variant to define variant's  personal wholesale prices#)}</b><br />
    <a If="getWholesalePrices()" href="{getLink()}">{t(#View parent product's wholesale prices#)}</a>
    {elseif:getWholesalePrices()}
    <b>{t(#Wholesale pricing#)}</b><br />
    <ul>
      <li FOREACH="getWholesalePrices(),wp">
        {t(#from#)} {wp.quantityRangeBegin}:
        {formatPrice(wp.price)}
        {if:wp.membership}
          ({wp.membership.name})
        {end:}
      </li>
    </ul>
    {else:}
    <b>{t(#Wholesale prices are not defined#)}</b>
    {end:}
  </div>
</div>
