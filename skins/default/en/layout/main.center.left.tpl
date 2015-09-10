{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Left sidebar
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="layout.main.center", weight="100")
 *}

<div id="sidebar-first" class="column sidebar" IF="layout.isSidebarFirstVisible()">
  <div class="section">
    {if:layout.isSidebarSingle()}
      <list name="sidebar.single" />
    {else:}
      <list name="sidebar.first" />
    {end:}
  </div>
</div>
