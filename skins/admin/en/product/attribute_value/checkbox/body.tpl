{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Attribute value (checkbox)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<label{if:attrValues.1.defaultValue} class="checked"{end:}>
  <span class="title">{getTitle()}{getModifierTitle():h}</span>
  <div class="checbox-box">
    <input type="hidden" name="{getName()}" value="{attrValues.0.id}" />
    <input type="checkbox" name="{getName()}" data-attribute-id="{attribute.id}" value="{attrValues.1.id}" checked="{isCheckedValue()}" data-unchecked="{attrValues.0.id}" />
  </div>
</label>
