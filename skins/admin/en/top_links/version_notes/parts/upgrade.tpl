{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * "Upgrade core" link
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerTagAttributes()):h}>
  <div class="box">
    <span class="warning">{getSVGImage(#images/info.svg#):h}</span>
    {if:isCoreUpgradeAvailable()&!areUpdatesAvailable()}
      <a href="{buildURL(#upgrade#,#start_upgrade#)}">{t(#Upgrade available#)}</a>
    {else:}
      <a href="{buildURL(#upgrade#,##,_ARRAY_(#mode#^#install_updates#))}" title="{t(#Updates for the X-Cart core and/or installed modules are available#)}">{t(#Updates are available#)}</a>
    {end:}
    <a class="close">{displaySVGImage(#images/icon-close-round.svg#):h}</a>
  </div>
  <div class="corner-box">
    <span class="corner"><a class="warning">{getSVGImage(#images/info.svg#):h}</a></span>
  </div>
</div>
