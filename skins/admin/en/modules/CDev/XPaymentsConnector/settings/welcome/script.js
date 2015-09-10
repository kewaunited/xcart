/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Sale widget controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */


function markStep(step) {

    var selector = '.step' + step + ', .step' + step + ' *';

    $(selector).mouseenter(
      function(e) {
        $(selector).addClass('hover');
      }
    ).mouseout(
      function() {
        $(selector).removeClass('hover');
      }
    );
}

$(document).ready(function() {

  for (var i = 1; i <= 3; i++) {

    markStep(i);
  }


});
