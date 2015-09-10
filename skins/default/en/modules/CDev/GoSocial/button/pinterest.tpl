{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pinterest button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="pinterest">
  <a href="{getButtonURL():h}" class="pin-it-button" {foreach:getButtonAttributes(),name,value} {name}="{value}"{end:}><img src="//assets.pinterest.com/images/PinExt.png" alt="{t(#Pin It#)}" style="border: 0;" /></a>
</div>
<widget class="\XLite\Module\CDev\GoSocial\View\ExternalSDK\Pinterest" />
