{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Storefront status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerTagAttributes()):h}>
  {if:isTogglerVisible()}
    <a href="{getLink()}" {printTagAttributes(getTogglerTagAttributes()):h}><div><span class="svg">{getSVGImage(#images/check.svg#):h}</span></div></a>
  {end:}
  <a href="{getOpenedShopURL()}" class="link opened" target="_blank">{getOpenTitle():h}</a>
  <span class="link closed">{getCloseTitle():h}</span>
</div>
