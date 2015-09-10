{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="payment-status">
  <div class="{getClass()}" role="alert">
    <span class="status-message-before">
      <list name="{getBeforeListName()}" />
    </span>

    <span IF="{isEnabled()}" class="status-message">{t(#This payment method is Active.#):h}</span>
    <span IF="{isDisabled()}" class="status-message">{t(#This payment method is Inactive.#):h}</span>

    <span class="status-message-after">
      <list name="{getAfterListName()}" />
    </span>
  </div>
</div>
