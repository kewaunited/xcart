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
      {t(#In this section you can review the recent payment transactions that have taken place at your store#):h}
    </div>

    <div class="features">
      <ul>
        <li><i class="fa fa-check"></i>{t(#Find transactions by ID#):h}</li>
        <li><i class="fa fa-check"></i>{t(#Search for transactions by date#):h}</li>
        <li><i class="fa fa-check"></i>{t(#Filter transactions by status#):h}</li>
      </ul>
    </div>

    <div class="actions">
      <a href="{getPricingURL()}" target="_blank">{t(#Choose the right plan#)}</a>
      <span class="or">{t(#or#)}</span>
      <widget class="\XLite\View\Button\Regular" label="Buy Business Edition" style="regular-main-button" jsCode="window.open('{getPurchaseLicenseURL()}', '_blank');" />
    </div>
  </div>

  <widget class="XLite\View\ModuleBanner" moduleName="QSL\AbandonedCartReminder" canClose="false"/>
</div>
