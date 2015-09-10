{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping estimator : address : zipcode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="shippingEstimator.address", weight="40")
 *}

<li class="type" IF="hasField(#type#)">
  <widget class="\XLite\View\FormField\Select\AddressType" fieldName="destination_type" value="{getType()}" label="{t(#Type#)}" />
</li>
