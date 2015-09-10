{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Activate license key form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="activate-key-form">

  <div IF="!isModuleActivation()" class="enter-key-hint">{t(#To activate your X-Cart license, enter your secret key into the field below and click Activate.#)}</div>
  <div IF="isModuleActivation()" class="enter-key-hint">
    {t(#Before installing a paid addon for this installation, you need to activate your X-Cart license.#):h}
  </div>

  <div class="license-key-form{if:isModuleActivation()} module-activation{end:}">

    <div IF="isModuleActivation()" class="enter-key-hint">
      {t(#Use the form below to provide your license information.#)}
    </div>

    <widget class="\XLite\View\Form\Module\ActivateKey" formAction="register_key" formName="getAddonForm" name="activate_key_form" />

    <div class="buttons model-form-buttons">
      <div class="addon-key"><input type="text" name="key" value="" placeholder="{t(#Enter your license key here#)}" /></div>

      <widget class="\XLite\View\Button\Submit" button-size="btn-default" label="{t(#Activate#)}" />
    </div>

    <div class="clear"></div>

  <widget name="activate_key_form" end />

  <div class="title">{t(#Need a license key?#)}</div>

  <div class="bottom-buttons">

    <widget class="\XLite\View\Button\Regular" label="Purchase premium license" style="regular-main-button" jsCode="window.open('{getPurchaseURL()}', '_blank');" />

    {if:!hasLicense()}
      <div class="text or">{t(#or#)}</div>

      <widget class="\XLite\View\Button\Link" label="Activate free license" style="regular-button activate-free-license-button" location="{getActivateFreeLicenseURL()}" />
    {end:}

    <div class="text">{t(#Contact us trial notice#,_ARRAY_(#contactURL#^getContactUsURL())):h}</div>

  </div>

  </div>
</div>
