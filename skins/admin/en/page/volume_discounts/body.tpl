{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * License message template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="license-message">
  <div class="alert alert-warning" role="alert">
    {t(#This feature is available only for paid (non-free) X-Cart license plans#,_ARRAY_(#pricingUrl#^getPricingURL())):h}
  </div>

  <div class="info">
    <div class="description">
      {t(#This page is intended for the management of volume discounts based on the order subtotal.#):h}
    </div>

    <div class="features">
      <ul>
        <li><i class="fa fa-check"></i>{t(#Set absolute or %-based discount rates;#):h}</li>
        <li><i class="fa fa-check"></i>{t(#Make a discount available to all customers or only to specific membership levels;#):h}</li>
        <li><i class="fa fa-check"></i>{t(#Set a single discount or add multiple volume discounts.#):h}</li>
      </ul>
    </div>

    <div class="actions">
      <a href="{getPricingURL()}" target="_blank">{t(#Choose the right plan#)}</a>
      <span class="or">{t(#or#)}</span>
      <widget class="XLite\View\Button\Regular" label="Buy Business Edition" style="regular-main-button" jsCode="window.open('{getPurchaseLicenseURL()}', '_blank');" />
    </div>
  </div>
</div>