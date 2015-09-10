{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * OnOff checkbox
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="{getWrapperClass()}">
  <input IF="!isDisabled()" type="hidden" name="{getName()}" value="" />
  <input IF="isDisabled()" type="hidden" name="{getName()}" value="{getValue()}" />
  <input{getAttributesCode():h} />
  <label for="{getFieldId()}">
    <span class="off-label">{t(getOffLabel())}</span>
    <span class="fa {getFontAwesomeClass()}"></span>
    <span class="on-label">{t(getOnLabel())}</span>
  </label>
</div>
