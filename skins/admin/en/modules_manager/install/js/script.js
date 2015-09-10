/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Common rountines
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(
function () {
  var module = _.keys(hash.get())[0];
  if (module) {
    jQuery('.module-' + module).addClass('active');
    window.setTimeout(function () {
      window.scrollBy(0, -150);
      jQuery('.module-' + module).addClass('non-active');
    }, 500);
  }
});
