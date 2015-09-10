{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Express checkout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.list.customer.info", weight="1100")
 *}
<div IF="isDisplayAdd2CartButton()" class="add-to-cart-button pp-button">
  {if:!product.inventory.isOutOfStock()}
    <widget class="\XLite\Module\CDev\Paypal\View\Button\ProductList\ExpressCheckout" productId="{product.product_id}" />
  {end:}
</div>
