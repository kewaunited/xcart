{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Minimum purchase quantities list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="section minimum-quantity-section">
  <div class="header minimum-quantity-header"><h2>{t(#Minimum purchase quantity#)}</h2></div>
  <ul class="table default-table">
    <li FOREACH="getMinQuantities(),qty">
      <widget
        class="\XLite\View\FormField\Input\Text"
        label="{qty.name}"
        mouseWheelIcon="false"
        fieldId=""
        fieldName="{getNamePostedData(qty.membershipId,#minQuantity#)}"
        value="{qty.quantity}" />
    </li>
  </ul>
</div>
