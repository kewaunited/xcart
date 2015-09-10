{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add to Cart button template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.list.customer.info", weight="1000")
 *}

<div IF="isDisplayAdd2CartButton()" class="add-to-cart-button">
  {if:!product.inventory.isOutOfStock()}
    {if:isGotoProduct(product)}
      <widget class="\XLite\View\Button\Link" label="Add to cart" style="regular-main-button add2cart add-to-cart link productid-{product.product_id}" location="{product.url}" />
    {else:}
      <widget class="\XLite\View\Button\Submit" label="Add to cart" style="regular-main-button add2cart add-to-cart productid-{product.product_id}" />
    {end:}
  {end:}
</div>
