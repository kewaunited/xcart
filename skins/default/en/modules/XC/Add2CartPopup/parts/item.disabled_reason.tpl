{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add to Cart popup page: cart disabled reason template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="add2cart_popup.item.buttons", weight="300")
 *}

<div IF="!cart.checkCart()" class="reason-details">
  {getDisabledReason():h}
</div>
