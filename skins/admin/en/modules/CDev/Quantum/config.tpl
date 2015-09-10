{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * QuantumGateway configuration page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="settings-text">
  {t(#Use of Restriction key must be disabled in your Quantum Gateway merchant center account at all times.#)}
</div>

<table cellspacing="1" cellpadding="5" class="settings-table">

  <tr>
    <td class="setting-name">
    <label for="settings_login">{t(#Login#)}</label>
    </td>
    <td>
    <input type="text" id="settings_login" name="settings[login]" value="{paymentMethod.getSetting(#login#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_hash">{t(#MD5 hash value#)}</label>
    </td>
    <td>
    <input type="text" id="settings_hash" name="settings[hash]" value="{paymentMethod.getSetting(#hash#)}" />
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
      <label for="settings_include_response">{t(#Include response in hash#)}</label>
    </td>
    <td>
      <select id="settings_include_response" name="settings[include_response]">
        <option value="Y"{if:paymentMethod.getSetting(#include_response#)=#Y#} selected="selected"{end:}>{t(#Yes#)}</option>
        <option value="N"{if:paymentMethod.getSetting(#include_response#)=#N#} selected="selected"{end:}>{t(#No#)}</option>
      </select>
      <widget
              class="\XLite\View\Tooltip"
              id="include-response-help"
              text="{t(#This value must be set in exactly the same way as it is set on the payment gateway end.#)}"
              caption=""
              isImageTag="true"
              className="help-icon" />
    </td>
  </tr>

</table>
