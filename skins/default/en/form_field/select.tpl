{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Common selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="input-field-wrapper {getWrapperClass()}">
<select {getAttributesCode():h}>
  {displayCommentedData(getCommentedData())}
  {foreach:getOptions(),optionValue,optionLabel}
    {if:isGroup(optionLabel)}
      <optgroup {getOptionGroupAttributesCode(optionValue,optionLabel):h}>
        {foreach:optionLabel.options,optionValue2,optionLabel2}
          <option {getOptionAttributesCode(optionValue2,optionLabel2):h}>{optionLabel2}</option>
        {end:}
      </optgroup>
    {else:}
      <option {getOptionAttributesCode(optionValue,optionLabel):h}>{optionLabel:stripTags}</option>
    {end:}
  {end:}
</select>
</span>
