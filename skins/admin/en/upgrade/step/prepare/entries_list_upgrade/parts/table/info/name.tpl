{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Upgrade entry name
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_upgrade.sections.table.info", weight="100")
 *}
<li class="name" IF="isModule(entry)">
  <a href="{getInstalledModuleURL(entry)}">{entry.getName()}</a>
</li>
<li class="name core" IF="!isModule(entry)">{entry.getName()}</li>
