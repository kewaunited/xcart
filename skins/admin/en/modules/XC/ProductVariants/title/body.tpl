{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product variant title 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div id="product_variant_title">
  <ul>
    <li>
      <a href="{buildURL(#product#,null,_ARRAY_(#product_id#^productVariant.product.id,#page#^#variants#))}">{t(#Variants list#)}</a> : {product.name}
    </li>
    <li FOREACH="productVariant.values,v" class="arrtibute">
      <b>{v.attribute.name}:</b> {v.asString()}<span>,</span>
    </li>
  </ul>
</div>
