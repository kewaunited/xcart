{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Layout settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="layout_settings", weight="20")
 *}

<div class="change-template">
  <div class="header">
    <h2>{t(#Choose a new template#)}</h2>

    <div class="right">
      <widget
        class="XLite\View\Button\SimpleLink"
        label="Visit the template store"
        location="{getTemplatesStoreURL()}"
        blank="true" />

      <span class="or">{t(#or#)}</span>

      <widget
        class="XLite\View\Button\Addon\ActivateLicenseKey"
        label="{t(#Activate purchased skin#)}" />

      <widget
        class="XLite\View\Button\Addon\EnterLicenseKey"
        label="{t(#Activate purchased skin#)}" />

      <widget
        class="XLite\View\Tooltip"
        className="help-icon"
        text="If you purchased a template but do not see it here, activate the license key that was provided to you." />
    </div>
    <div class="clear"></div>
  </div>
  <widget class="XLite\View\Model\ChangeTemplate" />
</div>
