{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Buttons
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<form action="{buildURL()}" method="post">
  <input type="hidden" name="target" value="upgrade" />
  <input type="hidden" name="action" value="download" />
  <input type="hidden" name="mode"   value="download_updates" />

  <div IF="!isFreeSpaceCheckAvailable()" class="free-space-warning-section">
      <h2>{t(#Check for available free disk space has failed#)}</h2>
      <div>{t(#You should check available free disk space yourself before continuing upgrade#)}</div>
  </div>

  <widget class="\XLite\View\FormField\Input\FormId" />

  <div class="incompatible-list">
    <widget class="\XLite\View\Upgrade\Step\Prepare\IncompatibleEntries" />
  </div>

  <div class="incompatible-list-actions">
    <list name="sections" type="inherited" />
    <div class="clear"></div>
  </div>
</form>
