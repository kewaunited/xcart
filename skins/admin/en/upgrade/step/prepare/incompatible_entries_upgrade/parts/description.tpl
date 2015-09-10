{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Info message
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.prepare.incompatible_entries_upgrade.sections", weight="100")
 *}
<widget
        IF="isRequestForUpgradeAvailable()"
        class="\XLite\View\Button\ProgressState"
        label="Request for upgrade"
        style="request-for-upgrade" />

<div IF="isRequestForUpgradeAvailable()" class="incompatible-module-list-description">
  {t(#The following modules currently do not have a version compatible with the X-Cart version to which you are upgrading#):h}
</div>

<div IF="!isRequestForUpgradeAvailable()"  class="incompatible-module-list-description">
  {t(#Please note that some of these modules are definitely incompatible with the upcoming upgrade and will be disabled in order to prevent the system crash#)}.
</div>
