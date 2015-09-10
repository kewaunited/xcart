{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top links node
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<li {printTagAttributes(getContainerTagAttributes()):h}>
  <widget template="{getLinkTemplate()}" />

  <div IF="hasChildren()" class="box">
    <div class="arr"></div>
    <ul>
      {foreach:getChildren(),child}
        {child.display()}
      {end:}
      <list name="{getListName()}" />
    </ul>
  </div>
</li>
