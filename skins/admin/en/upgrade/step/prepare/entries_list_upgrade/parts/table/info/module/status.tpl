{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Module status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_upgrade.sections.table.info.module", weight="300")
 *}
{if:isModule(entry)}
<li class="enabled" IF="entry.isEnabled()">{t(#enabled#)}</li>
<li class="disabled" IF="!entry.isEnabled()">{t(#now disabled#)}</li>
{end:}
