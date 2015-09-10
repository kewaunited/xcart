{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Switcher
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<ul class="table">
  <li>
    <widget
            class="XLite\View\FormField\Input\Checkbox\OnOff"
            label="Webmaster mode"
            labelHelp="Webmaster Mode allows you to change the storefront design in click-and-edit mode"
            onLabel="webmasterMode.Enabled"
            offLabel="webmasterMode.Disabled"
            fieldName="edit_mode"
            value="{config.XC.ThemeTweaker.edit_mode}"
            comment='{getStoreFrontLink()}' />
  </li>
</ul>
