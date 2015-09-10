

{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tax banner page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="tax-banner-alert alert module-banner alert-dismissable">
	<button type="button" class="close close-banner" data-module-name="{getModuleName()}"><span>&times;</span></button>
  	<p class="semibold">{t(#Avalara, a leader in US sales tax automation, provides a solution that can make your life easier by providing accurate and up-to-date tax rates for products you sell.#):h}</p>
  	<br>
  	<p>{t(#New to Avalara?#):h}</p>
  	<p>{t(#Existing Avalara user?#,_ARRAY_(#moduleSettings#^getModuleSettingsLink())):h}</p>
</div>
