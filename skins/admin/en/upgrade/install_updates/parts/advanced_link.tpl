{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Advanced mode link
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.install_updates.sections", weight="300")
 *}

<div IF="isAdvancedModeButtonVisible()" class="advanced-mode-button">
  <widget class="XLite\View\Button\Link" label="{t(getAdvancedModeButtonLabel())}" location="{getAdvancedModeURL()}" style="link" />
</div>
