/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Login 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'login-timer',
  '.login-box',
  function() {
    var timeLeft = jQuery(this).data('time-left');
    if (timeLeft) {
      (function() {
        timeLeft--;
        if (0 < timeLeft) {
          var min = parseInt(timeLeft / 60);
          var sec = timeLeft % 60;
          jQuery('#timer').text((10 > min ? '0' : '') + min +  ':' + (10 > sec ? '0' : '') + sec);
          setTimeout(arguments.callee, 1000);

        } else {
          jQuery('.login-box').removeClass('locked');
        }
      })()
    }
  }
);

core.microhandlers.add(
  'login-forgot-password',
  '.login-box',
  function() {
    var box = jQuery(this)

    var inp = box.find('input[name="login"]').eq(0);
    box.find('.forgot-password a').click(
      function(event) {
        if (inp.val()) {
          var link = jQuery(event.currentTarget);
          var url = link.attr('href');
          url += (url.search(/\?/) === -1 ? '?' : '&') + 'email=' + encodeURIComponent(inp.val());

          link.attr('href', url);
        }

        return true;
      }
    )

    
  }
);
