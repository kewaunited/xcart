{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * HTTPS settings page template 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="https-settings-dialog">

  {** top messages **}

  {if:!isEnabledHTTPS()}
    {if:isAvailableHTTPS()}
      <div class="alert alert-warning" IF="isValidSSL()">
        {t(#The secure protocol for your website is disabled.#)}
      </div>
      <div class="alert alert-danger" IF="!isValidSSL()">
        {t(#X-Cart could not find a valid SSL certificate on your server.#)}
        {t(#Before enabling HTTPS protocol read this article:#,_ARRAY_(#articleUrl#^getArticleUrl())):h}
      </div>
    {else:}
      <div class="alert alert-danger">
        {t(#X-Cart could not find a valid SSL certificate on your server.#)}
        {t(#Before enabling HTTPS protocol read this article:#,_ARRAY_(#articleUrl#^getArticleUrl())):h}
      </div>
    {end:}
  {else:}

    <div class="alert alert-success" IF="isValidSSL()">
      {t(#The secure protocol for your website is enabled.#)}
    </div>

    <div class="alert alert-warning" IF="isAvailableHTTPS()&!isValidSSL()">
      {t(#The HTTPS protocol is enabled for your website#)}
    </div>

  {end:}

  {** buttons **}

  {if:!isAvailableHTTPS()&isValidSSL()}
    <widget class="\XLite\View\Button\Regular" label="Purchase SSL certificate" jsCode="window.open('{getPurchaseURL()}','_blank')" style="regular-main-button action" />
  {end:}

  {if:areButtonsEnabled()}

    {if:!isEnabledHTTPS()}
      {if:!isAvailableHTTPS()&isValidSSL()}
        <widget class="\XLite\View\Button\ConfirmRegular" confirmText="Are you sure you want to enable https anyway?" label="Enable HTTPS" jsCode="self.location='{buildURL(#https_settings#,#enable_HTTPS#)}'" style="{getButtonStyle()}" />
      {else:}
        <widget class="\XLite\View\Button\Regular" label="Enable HTTPS" jsCode="self.location='{buildURL(#https_settings#,#enable_HTTPS#)}'" style="{getButtonStyle()}" />
      {end:}
    {end:}

    {if:isEnabledHTTPS()}
      <widget class="\XLite\View\Button\Regular" label="Disable HTTPS" jsCode="self.location='{buildURL(#https_settings#,#disable_HTTPS#)}'" style="regular-main-button action" />
    {end:}

  {end:}

  {** bottom messages **}

  <div class="note" IF="isEnabledHTTPS()&isValidSSL()">
    {t(#Your store is configured to use the secure protocol for the store back-end and checkout, sign-in and profile pages.#)}
  </div>

  <div class="note" IF="isAvailableHTTPS()&isValidSSL()&!isEnabledHTTPS()">
    {t(#We have found a valid SSL certificate installed on the server. Now you can switch the store to use the secure protocol for the store back-end and checkout, sign-in and profile pages.#)}
  </div>

  <div class="note" IF="isAvailableHTTPS()&!isValidSSL()">
    <div>
      {t(#X-Cart could not find a valid SSL certificate on your server.#)}
      {t(#Although you can switch the store to use the secure protocol for the website pages, most Internet browsers will likely display a warning message scaring your website visitors away.#)}
      <br>
      {t(#You can get more information using this service: #,_ARRAY_(#url#^getReadMoreLink())):h}
    </div>
  </div>
  <div class="note">
    <div IF="!isAvailableHTTPS()" class="purchase">
      {t(#To enable secure protocol for your website pages you need a valid SSL certificate purchased for the website domain and installed on your server.#,_ARRAY_(#domain#^getDomain())):h}
    </div>
  </div>

</div>
