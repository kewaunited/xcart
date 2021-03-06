{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Option :: signature
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget
  class="\XLite\View\FormField\Input\Checkbox"
  fieldId="opt-signature-{parcelIdx}"
  fieldName="parcelsData[{parcel.getId()}][optSignature]"
  fieldOnly="true"
  value="1"
  isChecked="{parcel.getOptSignature()}" />
