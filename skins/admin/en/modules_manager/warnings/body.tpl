{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<form action="{buildURL()}" method="post" class="no-popup-ajax-submit">
  <input type="hidden" name="target" value="upgrade" />
  <input type="hidden" name="action" value="install_addon_force" />
  <widget class="\XLite\View\FormField\Input\FormId" />
  {foreach:getModuleIds(),id}
  <input type="hidden" name="moduleIds[]" value="{id}" />
  {end:}
  <div class="warnings">
    <ul>
      <li IF="!isFreeSpaceCheckAvailable()" class="warning-entry free-space-warning-section">
        <div class='header'>{t(#Check for available free disk space has failed#)}</div>
        <div class='description'>{t(#You should check available free disk space yourself before continuing installation#)}</div>
      </li>
      <li FOREACH="getErrorMessages(),entryName,messageList" class="warning-entry">
        {foreach:messageList,message}
        {* :NOTE: do not add t(##) here: messages are already translated *}
        <div class="message-entry">{message}</div>
        {end:}
      </li>
    </ul>
    <table class="install-addon warning-entry-actions">
      <tr>
        <td IF='!getErrorMessages()'>
          <widget
            class="\XLite\View\Button\Submit"
            label="{t(#Install add-on#)}"
            style="submit-button main-button" />
        </td>
        <td IF='getErrorMessages()&!isAJAX()'>
          <widget
            class="XLite\View\Button\Link"
            location="{buildURL(#addons_list_marketplace#)}"
            label="{t(#Go to Marketplace#)}"
            style="main-button" />
        </td>
      </tr>
    </table>
  </div>

</form>