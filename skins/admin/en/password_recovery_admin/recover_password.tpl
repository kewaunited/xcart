{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Forgot your password
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="recover-password-wrapper">
  <div class="recover-password-box">

    <h1>{t(#Forgot your password?#)}</h1>

    <div class="recover-password-message">
      <p>{t(#To recover your password, please type in the valid e-mail address you use as a login#)}</p>
      <p>{t(#The confirmation URL link will be emailed to you shortly#)}</p>
    </div>

    <form action="{buildURL()}" method="post" name="recover_password">
      <input type="hidden" name="target" value="recover_password" />
      <input type="hidden" name="action" value="recover_password" />
      <widget class="\XLite\View\FormField\Input\FormId" />

      <table class="recover-password-form">

        <tr>
            <td class="email-field field"><input type="text" class="form-control" name="email" value="{email:r}" size="32" maxlength="128" placeholder="{t(#Email#)}" /></td>
        </tr>

        <tr IF="noSuchUser">
            <td class="error-message">{t(#No such user#)}: {email}</td>
        </tr>

        <tr class="buttons">
            <td><widget class="\XLite\View\Button\Submit" style="regular-main-button" /></td>
        </tr>

      </table>

    </form>

  </div>
</div>
