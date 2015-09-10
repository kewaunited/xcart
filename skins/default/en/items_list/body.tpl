{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * List main template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getWidgetTagAttributes()):h}>
  {displayCommentedData(getJSData()):s}

  <div IF="isHeadVisible()" class="head-h2 {getListHeadClass()}">{getListHead()}</div>
  <div IF="isPagerVisible()" class="list-pager">{pager.display():s}</div>
  <div IF="isHeaderVisible()" class="list-header"><list name="header" type="inherited" /></div>

  <widget template="{getPageBodyTemplate()}" />

  <div class="list-pager list-pager-bottom" IF="isPagerVisible()&pager.isPagesListVisible()">{pager.display():s}</div>
  <div IF="isFooterVisible()" class="list-footer"><list name="footer" type="inherited" /></div>

  <widget IF="isEmptyListTemplateVisible()" template="{getEmptyListTemplate()}" />
</div>
