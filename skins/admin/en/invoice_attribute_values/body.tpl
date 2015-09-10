{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Display product attribute values in invoice
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:!#1#=displayVariative}

  {foreach:item.getAttributeValues(),av}
    <li class="item-attribute-values-list-item">
      <span class="name">{av.getActualName()}:</span>
      <span {printTagAttributes(getValueContainerAttributes(av)):h}><span>{av.getActualValue()}</span></span>
    </li>
  {end:}

{else:}

  {if:1 < item.getAttributeValuesCount()}

    <li class="item-attribute-values-list-item">
      <span class="options-title">{t(#Options:#)}</span>
      {foreach:getPlainValues(),av}
        <span class="attribute-box">
          <span class="name">{av.getActualName()}:</span>
          <span {printTagAttributes(getValueContainerAttributes(av)):h} title="{av.getActualName()}">{av.getActualValue()}</span>
          <span class="separator">/</span>
        </span>
      {end:}
    </li>

    <li IF="getTextValues()" class="item-attribute-values-list-item-text">
      {foreach:getTextValues(),av}
        <div>
          <span class="name">{av.getActualName()}:</span>
          <span {printTagAttributes(getValueContainerAttributes(av)):h}><span>{av.getActualValue()}</span></span>
        </div>
      {end:}
    </li>

  {else:}

    <li FOREACH="item.getAttributeValues(),av" class="item-attribute-values-list-item">{av.getActualName()}: <span {printTagAttributes(getValueContainerAttributes(av)):h}><span>{av.getActualValue()}</span></span></li>

  {end:}

{end:}
