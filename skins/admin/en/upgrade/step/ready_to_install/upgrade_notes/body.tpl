{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Info about modified files
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="upgrade-notes-section">
  <div class="upgrade-notes-section-frame">

    <ul>
      <li FOREACH="getUpgradeNotes(),moduleName,notes">
        <div class="header">{moduleName}: {t(#Upgrade note#)}</div>

        <div FOREACH="notes,note" class="description">
          {note:h}
        </div>
      </li>
    </ul>

  </div>
</div>
