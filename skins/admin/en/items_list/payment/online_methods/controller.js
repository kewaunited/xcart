/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Payment methods controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/**
 * Payment methods controller
 */

ItemsList.prototype.listeners.popup = function(handler)
{
  core.autoload(PopupButtonInstallAddon);
  jQuery('.no-payment-methods-appearance .no-payments-found .search-worldwide').click(function(event) {
    var box = jQuery(this).parents('.add-payment-box.payment-type-A').eq(0);
    if (0 < box.length) {
      var form = jQuery('form', box);
      if (form) {
        jQuery('.search-conditions .country-condition select#country', form).val('');
        form.submit();
      }
    }
  });
};

jQuery().ready(
  function() {
    core.microhandlers.add(
      'NoPaymentMethodsFoundList',
      '.no-payment-methods-appearance',
      function (event) {
        console.log(jQuery(this));

        jQuery(".marketplace-block").hide();
      }
    );
    core.microhandlers.add(
      'PaymentMethodsList',
      '.payments-list.items-list',
      function (event) {
        jQuery(".marketplace-block").show();
      }
    );
  }
);
