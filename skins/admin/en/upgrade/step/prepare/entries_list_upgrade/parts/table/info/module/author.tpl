{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Module author
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_upgrade.sections.table.info.module", weight="200")
 *}
<li class="author" IF="isModule(entry)">
  <span class="title">{t(#Author#)}:</span>
  <span>{entry.getAuthor()}</span>
</li>
