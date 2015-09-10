{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item buttons
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.table.customer.columns", weight="50")
 *}

{if:!product.inventory.isOutOfStock()}
  {if:isGotoProduct(product)}
    <widget class="\XLite\View\Button\Link" style="add-to-cart product-add2cart link productid-{product.product_id}" label="Add to cart" location="{product.url}" />
  {else:}
    <widget class="\XLite\View\Button\Simple" style="add-to-cart product-add2cart productid-{product.product_id}" label="Add to cart" />
  {end:}
{else:}
  <widget class="\XLite\View\Button\Simple" style="out-of-stock" label="Out of stock" />
{end:}
