{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Trial upgrade notice
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.buttons.sections", weight="50")
 *}

<div IF="{hasExpiredKeys()}" class="alert alert-warning expired-keys">
  <div>{t(#There are expired license keys which do not allow proceed#)}</div>
  <ul>
    <li class="header">
      <div class="key-title">{t(#License key#)}</div>
      <div class="key-exp-date">{t(#Exp. date#)}</div>
    </li>
    <li FOREACH="getExpiredKeys(),i,k">
      <div class="key-title">{k.title}</div>
      <div class="key-exp-date">{k.expDate}</div>
      <div class="key-url"><a href="{k.purchaseURL}" target="_blank">{t(#Buy prolongation#)}</a></div>
    </li>
  </ul>
  <div class="actions">
    <widget IF="getAllKeysPurchaseURL()"
      class="\XLite\View\Button\Link"
      location="{getAllKeysPurchaseURL()}"
      label="{t(#Prolongate all keys#)}"
      style="main-button"
      blank="true" />
    <div class="revalidate-keys">
      <widget class="\XLite\View\Button\ProgressState" label="Re-validate license keys" />
    </div>
  </div>
  <div class="clear"></div>
</div>
