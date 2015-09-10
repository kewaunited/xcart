{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Entries list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.incompatible_entries_upgrade.sections", weight="200")
 *}
<ul class="update-module-list clearfix">
  <li class="update-module-info" FOREACH="getIncompatibleEntries(),entry">
    <list name="sections.table" type="inherited" entry="{entry}" />
  </li>
</ul>
