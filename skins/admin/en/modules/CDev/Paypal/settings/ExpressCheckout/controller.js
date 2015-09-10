/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Express Checkout controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
(function () {

  var checkAuthType = function (authType) {
    if ('email' == authType) {
      jQuery('.section_api').hide();
      jQuery('#email')
        .prop('disabled', false)
        .removeClass('no-validate');
      jQuery('li.input-text-email .star')
        .css('visibility', 'visible');

    } else {
      jQuery('.section_api').show();
      jQuery('#email')
        .prop('disabled', true)
        .addClass('no-validate');
      jQuery('li.input-text-email .star')
        .css('visibility', 'hidden');
    }
  };

  jQuery().ready(
    function () {
      var authTypeRadioButtons = jQuery('input:radio[name="api_type"]');

      authTypeRadioButtons.change(
        function () {
          checkAuthType(authTypeRadioButtons.filter(':checked').val());
        }
      );

      checkAuthType(authTypeRadioButtons.filter(':checked').val());
    }
  );

})();
