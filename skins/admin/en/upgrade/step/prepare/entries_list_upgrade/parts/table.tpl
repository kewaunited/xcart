{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Entries list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_upgrade.sections", weight="100")
 *}
<div class="toggle-list">
  <a href="javascript: void(0)" onclick="toggleModulesList();">{t(#view list#)}</a>
</div>

<div class="clearfix"></div>

<ul class="update-module-list upgrade clearfix">

  <li class="update-module-info" FOREACH="getUpgradeEntries(),entry">
    <list name="sections.table" type="inherited" entry="{entry}" />
  </li>

</ul>
