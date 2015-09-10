{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Updates list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.install_updates.sections", weight="200")
 *}

<form action="{buildURL()}" method="post">

  <input type="hidden" name="target" value="upgrade">
  <input type="hidden" name="action" value="start_upgrade" />
  <input IF="isAdvancedMode()" type="hidden" name="entries[enabled]" value="1" />

  <widget class="\XLite\View\FormField\Input\FormId" />

  <div class="update-module-list-frame">

    <ul class="update-module-list clearfix">

      <li class="update-module-info" FOREACH="getUpgradeEntries(),entry">
        <list name="sections.form" type="inherited" entry="{entry}" />
      </li>

    </ul>

    <widget class="\XLite\View\Button\Submit" label="{t(#Install updates#)}" style="center main-button" />

  </div>

</form>
