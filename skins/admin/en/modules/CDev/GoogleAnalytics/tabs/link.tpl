{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Link 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{if:isConfigured()}
  <p class="ga-note"><a href="https://www.google.com/analytics/web/" target="_blank" class="google-analytics">{t(#Advanced statistics with Google Analytics#)}</a></p>
{else:}
  <p class="ga-note"><a href="{getModuleLink()}" target="_blank" class="google-analytics">{t(#Configure the Google Analytics module to view the advanced statistics#)}</a></p>
{end:}
