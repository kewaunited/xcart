{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order address : billing
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="address.order.main", weight="200")
 *}

<div {printTagAttributes(getBillingContainerAttributes()):h}>
  <h3>{t(#Billing address#)}</h2>
  <div class="expander"><a href="#">{t(#Show#)}</a></div>
  <div class="collapser"><a href="#">{t(#Hide#)}</a></div>
  <a IF="isDisplayAddressButton()" href="{buildURL(#order#,##,_ARRAY_(#order_number#^order.orderNumber,#atype#^#b#,#widget#^#XLite\View\SelectAddressOrder#))}" class="btn btn-default address-book">{t(#Address book#)}</a>
  <widget class="XLite\View\Model\Address\Order" template="{getModelTemplate()}" addressType="billing" />
</div>

