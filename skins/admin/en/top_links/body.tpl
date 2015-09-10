{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top links
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div id="top-links">
  <ul>
    {foreach:getItems(),item}
      {if:!itemArrayPointer=1}
        <li class="separator"><div></div></li>
      {end:}
      {item.display()}
    {end:}
    <list name="top_links" />
  </ul>
</div>
