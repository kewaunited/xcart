{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Layout type selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="layout-types">
  <div class="hidden-field">
    <widget template="form_field/select.tpl" />
  </div>
  {foreach:getOptions(),optionValue,optionLabel}
    <div class="{getOptionClasses(optionValue, optionLabel)}" data-layout-type="{optionValue}" data-layout-preview="{getPreviewImage(optionValue)}">{getImage(optionValue):h}</div>
  {end:}
</div>
