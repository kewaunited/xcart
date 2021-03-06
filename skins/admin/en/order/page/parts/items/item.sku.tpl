{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * SKU item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.item.name", weight="10")
 *}
<li class="sku">
  <span class="name">{t(#SKU#)}</span>
  <span class="sku-value">{item.getSku()}</span>
</li>
