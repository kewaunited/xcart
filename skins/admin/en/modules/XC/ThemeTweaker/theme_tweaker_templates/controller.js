/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function WebmaserSwitcher () {
  var o = this;
  jQuery('#edit-mode').change(function (event)
  {
    event.stopImmediatePropagation();

    var switchWrapper = jQuery('.webmaster-mode-switch');
    if (switchWrapper.length) {
      assignShadeOverlay(switchWrapper);
    }

    core.get(
      URLHandler.buildURL({
        target: 'theme_tweaker_templates',
        action: 'switch'
      }),
      function () {
        if (switchWrapper) {
          unassignShadeOverlay(switchWrapper);
        }
      }
    );

    jQuery('.edit-mode-comment a').toggleClass('hidden', !jQuery(this).is(':checked'));

    return false;
  });
}

core.autoload(WebmaserSwitcher);