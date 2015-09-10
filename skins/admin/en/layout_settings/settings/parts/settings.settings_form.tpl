{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Layout settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="layout_settings.settings", weight="40")
 *}
<div IF="showSettingsForm()" class="settings-form">
  <widget class="XLite\View\Button\Link" location="{getSettingsForm()}" label="{t(#Edit custom options#)}"/>
</div>
