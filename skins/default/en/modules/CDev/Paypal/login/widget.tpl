{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Social Login sign-in button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="social-login-note note-before" IF="getTextBefore()">
  {getTextBefore()}
</div>

<div class="social-login-container">
  <ul class="social-login">
    <li class="social-net-element social-net-{getButtonStyle()} social-net-PayPal">
      <a href="javascript: void(0);" rel="{getAuthURL()}" class="paypal-login button" onclick="return !PaypalLogin.openPopup(this);">
        <i class="fa fa-paypal"></i>
        <span class="provider-name">{t(#PayPal#)}</span>
      </a>
    </li>
  </ul>
</div>

<div class="social-login-note note-after" IF="getTextAfter()">
  {getTextAfter()}
</div>
