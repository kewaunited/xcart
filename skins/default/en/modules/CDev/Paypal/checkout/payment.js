/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Stripe initialize
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.bind(
  'checkout.main.initialize',
  function() {
    core.bind(
      'checkout.common.ready',
      function(event, state) {
        var box = jQuery('.paypal-in-context-box');
        if (box.length) {
          form = box.closest('form').get(0);
          core.post(
            URLHandler.buildURL({
              target: 'checkout',
              action: 'setOrderNote'
            }),
            null,
            {
              notes: $('textarea[name="notes"]').val()
            }
          );
          paypalExpressCheckout(form, false, form.popupUrl.value);

          state.state = false;
        }
      }
    );
  }
);
