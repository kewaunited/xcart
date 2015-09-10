{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Block content : footer
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="paypal.welcome.content", weight="20")
 *}

<div class="welcome-footer">

  <div class="bg"></div>

  <div class="do-not-show">
    <input type="checkbox" name="hide_welcome_block_paypal" id="hide_welcome_block_paypal" class="hide-welcome-block" />
    <label for="hide_welcome_block_paypal">{t(#Do not show at startup anymore#)}</label>
  </div>
  <div class="close-button">{t(#CLOSE#)}</div>
</div>
