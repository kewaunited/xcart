{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="templates">
  <div class="hidden-field">
    <widget template="form_field/select.tpl" />
  </div>

  <div class="templates-list">

  {foreach:getSkinModules(),module}
    <div class="{getStyleClass(module)}" data-template-id="{getModuleId(module)}" data-is-redeploy-required="{isRedeployRequired(module)}">
      <img src="{getModuleImage(module)}" alt="{getModuleLabel(module)}" />
      <div class="name">
        {getModuleLabel(module)}
      </div>
    </div>
  {end:}

  </div>
</div>

<div class="quote">
  {t(#Need custom design? We can modify this template or create a completely unique design for you#):h}

  <widget
    class="XLite\View\Button\Link"
    label="FREE quote"
    location="{getFreeQuoteURL()}"
    blank="true"
    style="regular-main-button" />

</div>