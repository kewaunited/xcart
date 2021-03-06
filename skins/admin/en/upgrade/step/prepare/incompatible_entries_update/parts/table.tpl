{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Entries list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.incompatible_entries_update.sections", weight="200")
 *}

<table class="incompatible-modules-list">
  <tr FOREACH="getIncompatibleEntries(),entry">
    <list name="sections.table.columns" type="inherited" entry="{entry}" />
  </tr>
</table>
