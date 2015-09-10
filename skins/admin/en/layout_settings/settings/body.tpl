{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Layout settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="layout-settings settings">
  <div class="preview">
    <img IF="{getPreviewImageURL()}" src="{getPreviewImageURL()}" alt="{getCurrentSkinName()}" />
  </div>
  <div class="settings-list">
    <list name="layout_settings.settings" />
  </div>
</div>