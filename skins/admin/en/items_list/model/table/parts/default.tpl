{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Default radio
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="default-value-checkbox{if:entity.getDefaultValue()} checked{end:}" title="{getDefaultActionTitle()}">
  <widget class="XLite\View\FormField\Input\Radio" value="{entity.getId()}" fieldName="defaultValue" fieldOnly="true" isChecked="{entity.getDefaultValue()}" />
</div>
