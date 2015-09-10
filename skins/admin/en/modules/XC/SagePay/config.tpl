{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * SagePay Form protocol configuration page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="!paymentMethod.isMcryptDecrypt()" class="top-note warning">
  <div>{t(#You need to install the PHP mcrypt extension to use the Sage Pay integration#)}</div>
</div>

<table cellspacing="1" cellpadding="5" class="settings-table">

  <tr>
    <td class="setting-name">
    <label for="settings_login">{t(#Sage Pay vendor name#)}</label>
    </td>
    <td>
    <input type="text" id="settings_vendorName" name="settings[vendorName]" value="{paymentMethod.getSetting(#vendorName#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_key">{t(#Sage Pay password#)}</label>
    </td>
    <td>
    <input type="text" id="settings_password" name="settings[password]" value="{paymentMethod.getSetting(#password#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_test">{t(#Test/Live mode#)}</label>
    </td>
    <td>
    <select id="settings_test" name="settings[test]">
      <option value="1" selected="{isSelected(paymentMethod.getSetting(#test#),#1#)}">{t(#Test mode: Test#)}</option>
      <option value="0" selected="{isSelected(paymentMethod.getSetting(#test#),#0#)}">{t(#Test mode: Live#)}</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_prefix">{t(#Sage pay invoice number prefix#)}</label>
    </td>
    <td>
    <input type="text" id="settings_prefix" value="{paymentMethod.getSetting(#prefix#)}" name="settings[prefix]" />
    </td>
  </tr>

</table>

<script type="text/javascript">
  jQuery("#settings_currency").val("{paymentMethod.getSetting(#currency#)}");
</script>
