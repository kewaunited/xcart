{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Upgrade entry icon
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.entries_list_upgrade.sections.table", weight="100")
 *}
<div class="module-icon">
  {if:entry.hasIcon()}
  <img src="{entry.getPublicIconURL()}" class="addon-icon" alt="{entry.getName()}" />
  {else:}
  <img src="images/spacer.gif" class="addon-icon addon-default-icon" alt="{entry.getName()}" />
  {end:}
</div>
