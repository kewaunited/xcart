{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : line 1
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.operations", weight="100")
 *}

<div class="line-1 clearfix">

  <div IF="order.isPaymentSectionVisible()" class="order-part payment">
    <h2>{t(#Payment method#)}:</h2>
    <div class="box"><list name="order.payment" /></div>
  </div>

  <div IF="order.isShippingSectionVisible()" class="order-part shipping">
    <h2>{t(#Shipping method#)}:</h2>
    <div class="box"><list name="order.shipping" /></div>
  </div>

  <div class="actions">
    <list name="order.actions" />
  </div>

<!--
  <div class="note">
    <list name="order.note" />
  </div>
  <div class="clear"></div>
-->
</div>
