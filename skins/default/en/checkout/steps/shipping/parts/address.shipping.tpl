{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout shipping address form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Form\Checkout\UpdateProfile" name="shippingAddress" className="address shipping-address" />
  <ul class="form shipping-address-form">
    <li FOREACH="getAddressSchemaFields(),fieldName,fieldData" class="item-{fieldName} {fieldData.additionalClass} clearfix">
      {displayCommentedData(getFieldCommentedData(fieldData))}
      {fieldData.widget.display()}
      <list name="checkout.shipping.address.{fieldName}" address="{getAddressInfo()}" fieldName="{fieldName}" fieldData="{fieldData}" />
    </li>
    <list name="checkout.shipping.address" address="{getAddressInfo()}" />
  </ul>
<widget name="shippingAddress" end />
