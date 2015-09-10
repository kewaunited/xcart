{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Main template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul {printTagAttributes(getContainerTagAttributes()):h}>
  {foreach:getBranch(),cell}
    <li {printTagAttributes(getItemContainerTagAttributes(cell.type,cell.id)):h}>
      <div class="item-box">
        {if:cell.url}
          <a href="{cell.url}" class="item">{cell.name}</a>
        {else:}
          <span class="item">{cell.name}</span>
        {end:}
      </div>
      {if:isDisplayChild(cell.type,cell.id)}
        <widget class="XLite\Module\XC\Sitemap\View\Sitemap\Branch" type="{cell.type}" id="{cell.id}" level="{getNextLevel()}" />
      {end:}
    </li>
  {end:}
</ul>
