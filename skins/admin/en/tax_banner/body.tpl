{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tax banner page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="tax-banner">
  <div class="subbox marketplace">
    <div class="svg">{getSVGImage(#images/tax_banner.svg#):h}</div>
    <p>{t(#To setup Tax Rates, find and install the appropriate addons from Marketplace#,_ARRAY_(#url#^buildURL(#addons_list_marketplace#,##,_ARRAY_(#tag#^#Taxes#,#clearSearch#^#1#)))):h}</p>
    <div class="horizontal-divider">
    	<span>{t(#OR#)}</span>
    </div>
    <div class="svg">{getSVGImage(#images/avalara_logo.svg#):h}</div>
    <p>{t(#Simplify tax compilance process and reduce the sales tax audit risk with AvaTax Sales Tax Automation#,_ARRAY_(#url#^getAvaTaxLink())):h}</p>
  </div>
</div>
