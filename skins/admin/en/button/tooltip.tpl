{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Regular button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="button-tooltip-wrapper">
<div class="{getWrapperClass()}">

  <widget template="button/regular.tpl" />

  <div IF="getButtonTooltip()" class="help-text" style="display: none;">{getButtonTooltip():h}</div>
</div>
<widget IF="getSeparateTooltip()"
        class="\XLite\View\Tooltip"
        text="{getSeparateTooltip():h}"
        isImageTag=true
        className="help-icon" />

</div>