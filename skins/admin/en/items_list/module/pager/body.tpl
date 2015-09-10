{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pager
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="addons-pager-found-title">{getPagerTitle()}</div>

<div class="addons-pager-list-wrapper" IF="isPagesListVisible()|isItemsPerPageVisible()">

  <div class="addons-pager-list-container">

    <ul IF="isPagesListVisible()" class="pagination grid-list addons-pager-list">
      <li FOREACH="getPages(),page" class="{page.classes}">
        <a IF="page.href" href="{page.href}" class="{page.page}" title="{t(page.title)}" data-text="{t(page.text)}">{t(page.text):h}</a>
        <span IF="!page.href" class="{page.page}" title="{t(page.title)}">{t(page.text):h}</span>
      </li>
    </ul>

    <div IF="isItemsPerPageVisible()" class="items-per-page-wrapper">
      <span>{t(#Items per page#)}:</span>
      <select name="itemsPerPage" class="page-length not-significant">
        <option FOREACH="getItemsPerPageRanges(),range" value="{range}" selected="{isRangeSelected(range)}">{range}</option>
      </select>
    </div>

  </div>

</div>

<div class="addons-pager-buttons">
  <list name="buttons" type="inherited" />
</div>

<div class="addons-pager-bottom-title">{getPagerBottomTitle():h}</div>

<list name="tail" type="inherited" />
