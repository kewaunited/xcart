{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Login widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="login-box-wrapper">
  <div class="login-box{if:isLocked()} locked" data-time-left="{getTimeLeftToUnlock()}{end:}">

    <h1>{t(#Administration Zone#)}</h1>

    <h2 IF="{isLocked()}" class="timer-header">{t(#Login is locked out#)}</h2>

    <div class="additional-note" IF="additional_note">{additional_note:r}</div>

    <form id="login_form" action="{buildURL(#login#)}" method="post" name="login_form">
      <input type="hidden" name="target" value="login" />
      <input type="hidden" name="action" value="login" />
      <widget class="\XLite\View\FormField\Input\FormId" />

      <table>
        <tbody class="fields">
          <tr>
            <td><input type="text" class="form-control" name="login" value="{login:r}" size="32" maxlength="128" autocomplete="off" placeholder="{t(#Email#)}" /></td>
          </tr>
          <tr>
            <td><input type="password" class="form-control" name="password" value="{password:r}" size="32" maxlength="128" autocomplete="off" placeholder="{t(#Password#)}" /></td>
          </tr>
        </tbody>

        <tbody IF="{isLocked()}" class="timer">
          <tr>
            <td>
              {t(#Time left#)}: <span id="timer"></span>
            </td>
          </tr>
        </tbody>

        <tbody class="buttons">
          <tr>
            <td>
              <widget class="\XLite\View\Button\Submit" label="Log in" style="regular-main-button" />
              <div class="forgot-password">
                <a href="{buildURL(#recover_password#)}">{t(#Forgot password?#)}</a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </form>

  </div>
</div>
