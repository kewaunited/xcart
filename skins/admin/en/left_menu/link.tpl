{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Left side menu link
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="line">
  {if:getLink()}
    <a href="{getLink()}" class="link"{if:getTooltip()} title="{getTooltip()}"{end:}{if:getBlankPage()} target="_blank"{end:}>{getIcon():h}<span IF="getTitle()">{getTitle():h}</span></a>
  {else:}
    <span class="link"{if:getTooltip()} title="{getTooltip()}"{end:}>{getIcon():h}<span IF="getTitle()">{getTitle():h}</span></span>
  {end:}
  <a IF="getLabel()" href="{getLabelLink()}" class="label"><span title="{getLabelTitle()}">{getLabel():h}</span></a>
</div>
