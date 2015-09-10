{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Main template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div IF="isDeveloperMode()" id="profiler-messages"></div>

<widget class="\XLite\View\TopMessage" />

<div id="page-wrapper">

  <widget template="body/header.tpl" />

  <div id="page-container">
    <div id="sidebar-first" class="side-bar" IF="layout.isSidebarFirstVisible()">
      <list name="admin.main.page.content.left" />
    </div>

    <div id="main">
      {if:isForceChangePassword()}
        <widget class="\XLite\View\Model\Profile\ForceChangePassword" />
      {else:}
        <list name="admin.main.page.content.center" />
      {end:}

      <div id="sub-section" IF="isViewListVisible(#admin.main.page.content.sub_section#)">
        <list name="admin.main.page.content.sub_section" />
      </div>

      <widget template="body/footer.tpl" />
    </div>

  </div>

</div>
