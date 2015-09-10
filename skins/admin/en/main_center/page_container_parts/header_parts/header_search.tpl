{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Header search
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerTagAttributes()):h}>

  <widget class="XLite\View\Form\HeaderSearch" name="hsForm" />

    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{t(#Search in#)} <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
          {foreach:getMenuItems(),item}
            <li><a href="#" data-code="{item.code}" data-placeholder="{item.placeholder}">{item.name}</a></li>
          {end:}
        </ul>
      </div>
      <input type="text" class="form-control" name="substring" value="" placeholder="{currentItem.placeholder}" />
    </div>
    <input type="hidden" name="code" value="{currentItem.code}" />

  <widget name="hsForm" end />

</div>
