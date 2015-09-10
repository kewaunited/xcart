{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Redirect URL protocol selector selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="isEditableReturnURLProtocol()" class="fa fa-pencil-square-o toggle-edit"></div>
<div class="view">{getSignInReturnURL()}</div>
<div IF="isEditableReturnURLProtocol()" class="value" style="display: none;">
<select id="{getFieldId()}" name="{getName()}"{getAttributesCode():h}>
  <option FOREACH="getOptions(),optionValue,optionLabel" value="{optionValue}" selected="{optionValue=getValue()}">{optionLabel:h}</option>
</select>
<div>{getSignInReturnURL(false)}</div>
</div>
