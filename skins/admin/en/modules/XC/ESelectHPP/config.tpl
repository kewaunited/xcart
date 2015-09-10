{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * eSelect configuration page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<table cellspacing="1" cellpadding="5" class="settings-table eselect">
  <tr>
    <td colspan="2" class="note">
      {t(#To set up the integration, go to the _Site management_#):h}
      <ol>
        <li>{t(#The Store ID and HPP Key value must be exactly the same as on it.#)}</li>
        <li>{t(#The Approved URL value must be exact as this:#)}
           <div class="eselect-webhook">
             <div class="url">{getSecureShopURL(#cart.php?target=payment_return#)}</div>
           </div>
        </li>
        <li>
          {t(#The Declined URL value must be exact as this:#)}
           <div class="eselect-webhook">
             <div class="url">{getSecureShopURL(#cart.php?target=payment_return#)}</div>
           </div>
        </li>
        <li>{t(#Set the Response Method setting to Sent to your server as a POST.#)}</li>
        <li>{t(#Enable the Use Enhanced Cancel option.#)}</li>
      </ol>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_login">{t(#Store ID#)}</label>
    </td>
    <td>
    <input type="text" id="settings_account" name="settings[store_id]" value="{paymentMethod.getSetting(#store_id#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_key">{t(#HPP Key#)}</label>
    </td>
    <td>
    <input type="text" id="settings_secret" name="settings[hpp_key]" value="{paymentMethod.getSetting(#hpp_key#)}" class="validate[required,maxSize[255]]" />
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

  <tr>
    <td class="setting-name">
    <label for="settings_prefix">{t(#Order prefix#)}</label>
    </td>
    <td>
    <input type="text" id="settings_prefix" value="{paymentMethod.getSetting(#prefix#)}" name="settings[prefix]" />
    </td>
  </tr>

</table>

<script type="text/javascript">
  jQuery("#settings_currency").val("{paymentMethod.getSetting(#currency#)}");
  jQuery("#settings_language").val("{paymentMethod.getSetting(#language#)}");
</script>
