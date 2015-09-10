{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tooltip widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="tooltip-main">
{if:isImageTag()}
<i {getAttributesCode():h}></i>
{else:}
<span {getAttributesCode():h}>{getParam(#caption#)}</span>
{end:}
<div IF="getParam(#helpWidget#)" class="help-text" style="display: none;"><widget class="{getParam(#helpWidget#)}" /></div>
<div IF="!getParam(#helpWidget#)" class="help-text" style="display: none;">{getParam(#text#):h}</div>
</div>
<div class="clear"></div>
