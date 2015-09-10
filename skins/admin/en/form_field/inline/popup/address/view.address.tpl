{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Address fields
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="address-section">
  {foreach:getAddressSectionData(getEntityValue(),#1#),idx,f}
    <li class="{f.css_class} address-field">
      <span class="address-title">{t(f.title)}: </span><span class="address-field">{f.value}</span><span class="address-comma">,</span><span class="address-space">&nbsp;</span>
    </li>
  {end:}
</ul>

