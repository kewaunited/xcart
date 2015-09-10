{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="marketplace.top-controls", weight="350")
 *}

<div IF="isVisibleAddonFilters()" class="addons-filters">

  <div class="addons-selectors">

    <form name="addons-filter" method="GET" action="{buildURL()}">
      <widget class="\XLite\View\FormField\Input\FormId" />
      <input FOREACH="getURLParams(),name,value" type="hidden" name="{name}" value="{value}" />

      <div class="tag-filter-box combine-selector">
        <widget
                class="\XLite\View\FormField\Select\AddonsSort"
                fieldId="tag-filter"
                fieldName="tag"
                options="{getTagOptionsForSelector()}"
                value="{getTagOptionsValueForSelector()}"
                attributes="{_ARRAY_(#data-classes#^#tag-filter#,#data-height#^#100%#)}"
                label="{t(#Tags#)}"
                />
      </div>

      <div class="vendor-filter-box combine-selector">
        <widget
                class="\XLite\View\FormField\Select\AddonsSort"
                fieldId="vendor-filter"
                fieldName="vendor"
                options="{getVendorOptionsForSelector()}"
                value="{getVendorOptionsValueForSelector()}"
                attributes="{_ARRAY_(#data-classes#^#vendor-filter#,#data-height#^#100%#)}"
                label="{t(#Marketplace-Vendor#)}"
                />
      </div>

      <div class="price-filter-box combine-selector">
        <widget
                class="\XLite\View\FormField\Select\AddonsSort"
                fieldId="price-filter"
                fieldName="price"
                disableSearch="true"
                options="{getPriceOptionsForSelector()}"
                value="{getPriceOptionsValueForSelector()}"
                attributes="{_ARRAY_(#data-classes#^#price-filter#,#data-height#^#100%#)}"
                label="{t(#Price#)}"
                />
      </div>

    </form>

  </div>

  <list name="marketplace.addons-filters" />

  <div class="clear"></div>

</div>

<div IF="isVisibleAddonFilters()" class="addons-sort">
  <ul class="addons-sort-box text-selector">
    {foreach:getSortOptionsForSelector(),url,name}
    <li class="sort{if:url=getSortOptionsValueForSelector()} selected{end:}"><a href="{url}">{name}</a></li>
    {end:}
  </ul>
</div>
