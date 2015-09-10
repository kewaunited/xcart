{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Layout settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="layout_settings.settings", weight="35")
 *}
<div class="webmaster-mode-switch">
  <widget
    class="XLite\View\FormField\Input\Checkbox\OnOff"
    label="Webmaster mode"
    labelHelp="Webmaster Mode allows you to change the storefront design in click-and-edit mode"
    fieldName="edit_mode"
    value="{config.XC.ThemeTweaker.edit_mode}"
    comment="{getStoreFrontLink()}" />
</div>
