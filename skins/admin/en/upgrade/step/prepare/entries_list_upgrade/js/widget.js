/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Incompatible entries list controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
function toggleModulesList() {
  var list = jQuery('.update-module-list.upgrade');

  if (list.is(':visible')) {
    list.hide();
    jQuery('.toggle-list a').text(core.t('show list'))
  } else {
    list.show();
    jQuery('.toggle-list a').text(core.t('hide list'))
  }
}
