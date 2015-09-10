{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Billing adddress
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Form\Checkout\UpdateProfile" name="billingAddress" className="address billing-address" />
  <ul class="form">
    <list name="checkout.payment.address.before" address="{getAddressInfo()}" />
      <li FOREACH="getAddressSchemaFields(),fieldName,fieldData" class="address-item item-{fieldName} {fieldData.additionalClass} clearfix">
        {displayCommentedData(getFieldCommentedData(fieldData))}
        {fieldData.widget.display()}
        <list name="checkout.payment.address.{fieldName}" address="{getAddressInfo()}" fieldName="{fieldName}" fieldData="{fieldData}" />
      </li>
    <list name="checkout.payment.address.after" address="{getAddressInfo()}" />
  </ul>
<widget name="billingAddress" end />
