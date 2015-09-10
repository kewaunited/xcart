{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Upgrade entry icon
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.install_updates.sections.form", weight="200")
 *}

<ul class="module-info">
  <list name="sections.form.info" type="inherited" entry="{entry}" />
</ul>
{if:isAdvancedMode()}
<div IF="isEntrySelectable(entry)" class="advanced-checkbox{if:!isModule(entry)} core{end:}">
  <label IF="{isModule(entry)}" for="entry-{getModuleID(entry)}">
    <input type="checkbox" id="entry-{getModuleID(entry)}" name="entries[{getModuleID(entry)}]" value="1" checked />
    {t(#Update#)}
  </label>
  <label IF="{!isModule(entry)}" for="entry-core">
    <input type="checkbox" id="entry-core" name="entries[core]" value="1" checked />
    {t(#Update#)}
  </label>
</div>
<div IF="!isEntrySelectable(entry)" class="advanced-checkbox not-selectable">
{t(#Will be updated if core update is selected#)}
</div>
{end:}
<div class="clear"></div>
