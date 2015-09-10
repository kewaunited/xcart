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
      {t(#This page is intended for the creation and management of discount coupons.#):h}
    </div>

    <div class="features">
      <ul>
        <li><i class="fa fa-check"></i>{t(#the dates the coupon should be valid for;#):h}</li>
        <li><i class="fa fa-check"></i>{t(#the order subtotal range for which the coupon can be used;#):h}</li>
        <li><i class="fa fa-check"></i>{t(#the categories and product classes to which the coupon may be applied;#):h}</li>
        <li><i class="fa fa-check"></i>{t(#whether the coupon may be used by everyone or only by users with specific memberships.#):h}</li>
      </ul>
    </div>

    <div class="actions">
      <a href="{getPricingURL()}" target="_blank">{t(#Choose the right plan#)}</a>
      <span class="or">{t(#or#)}</span>
      <widget class="XLite\View\Button\Regular" label="Buy Business Edition" style="regular-main-button" jsCode="window.open('{getPurchaseLicenseURL()}', '_blank');" />
    </div>
  </div>
</div>