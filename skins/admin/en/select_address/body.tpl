{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pick address from address book
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getAddressContainerAttributes()):h}>

  {if:hasAddresses()}

    <ul class="addresses">
      <li FOREACH="getAddresses(),address" class="{getItemClassName(address,addressArrayPointer)}">
        <widget template="select_address/address.tpl" address="{address}" />
        <div IF="isShipping(address)" class="shipping"></div>
        <div IF="isBilling(address)" class="billing"></div>
      </li>
    </ul>

  {else:}

    <p>{t(#Addresses list is empty#)}</p>

  {end:}

</div>
