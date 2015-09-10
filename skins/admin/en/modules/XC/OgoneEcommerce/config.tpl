{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * OgoneEcomerce configuration page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="settings-text">
  {t(#Ogone signup#,_ARRAY_(#url#^getOgoneSignupURL())):h}
  {t(#Ogone settings note#,_ARRAY_(#URL#^getShopURL())):h}
</div>

<table cellspacing="1" cellpadding="5" class="settings-table">
    <tr>
        <td class="setting-name">
            <label for="settings_pspid">{t(#Ogone PSPID#)}</label>
        </td>
        <td>
            <input type="text" id="settings_pspid" name="settings[pspid]" value="{paymentMethod.getSetting(#pspid#)}" class="validate[required,maxSize[255]]"/>
        </td>
    </tr>

    <tr>
        <td class="setting-name">
            <label for="settings_shaIn">{t(#SHA-IN passphrase#)}</label>
        </td>
        <td>
            <input type="text" id="settings_shaIn" name="settings[shaIn]" value="{paymentMethod.getSetting(#shaIn#)}" class="validate[required,maxSize[255]]"/>
        </td>
    </tr>

    <tr>
        <td class="setting-name">
            <label for="settings_shaOut">{t(#SHA-OUT passphrase#)}</label>
        </td>
        <td>
            <input type="text" id="settings_shaOut" name="settings[shaOut]" value="{paymentMethod.getSetting(#shaOut#)}" class="validate[required,maxSize[255]]"/>
        </td>
    </tr>

    <tr>
        <td class="setting-name">
            <label for="settings_prefix">{t(#Invoice number prefix#)}</label>
        </td>
        <td>
            <input type="text" id="settings_prefix" value="{paymentMethod.getSetting(#prefix#)}" name="settings[prefix]" />
        </td>
    </tr>

    <tr>
        <td class="setting-name">
            <label for="settings_mode">{t(#Test/Live mode#)}</label>
        </td>
        <td>
            <widget
                    class="\XLite\View\FormField\Select\TestLiveMode"
                    fieldId="settings_mode"
                    fieldName="settings[mode]"
                    fieldOnly=true
                    value="{paymentMethod.getSetting(#mode#)}" />
        </td>
    </tr>
</table>
