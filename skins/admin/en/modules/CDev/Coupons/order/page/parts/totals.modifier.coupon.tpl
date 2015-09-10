{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifier default template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="coupon-row clearfix">
  <div class="title">
    {t(#Coupon discount#)}:
    <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
  </div>

  <div class="value">
    {surcharge.formField.display():h}
    <input type="hidden" name="auto[surcharges][{surcharge.code}][value]" value="1" />
    <ul>
      <li class="new hidden">
        <span class="code"></span>
        <span class="separator">&ndash;</span>
        <span class="cost">{formatPriceHTML(#0#,order.currency):h}</span>
        <a href="#" class="remove" title="{t(#Remove#)}"><i class="fa fa-trash-o"></i></a>
        <input type="hidden" name="newCoupon[]" value="" />
      </li>
      <li FOREACH="getUsedCoupons(),coupon">
        <span class="code">{coupon.code}</span>
        <span class="separator">&ndash;</span>
        <span class="cost">{formatPriceHTML(coupon.value,order.currency):h}</span>
        <a href="#" class="remove" title="{t(#Remove#)}"><i class="fa fa-trash-o"></i></a>
        <input type="hidden" name="removeCoupons[{getCouponCodeHash(coupon)}]" value="" />
      </li>
    </ul>

    <div class="add-new">
      <a href="#" class="add">{t(#Add coupon#)}</a>
      <div class="box">
        <widget class="XLite\Module\CDev\Coupons\View\FormField\NewCode" fieldName="couponCode" fieldOnly="true" label="{t(#Coupon#)}" />
        <button type="button" class="btn regular-button action add-coupon"><span>{t(#Redeem#)}</span></button>
      </div>
    </div>

    <list name="order.base.totals.modifier.value" surcharge="{surcharge}" sType="{surcharge.code}" order="{order}" />
  </div>
</div>
