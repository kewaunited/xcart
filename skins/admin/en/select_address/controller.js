/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Pick address from address book controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
core.bind(
  'afterPopupPlace',
  function() {
    var box = jQuery('.select-address');
    box.find('.addresses > li').click(
      function() {
        var id = core.getValueFromClass(this, 'address')

        // Save address id
        var boxName;
        var shipping = jQuery('input[name="shippingAddress[id]"]');
        var billing = jQuery('input[name="billingAddress[id]"]');
        var same = jQuery('input[name="shippingAddress[same_as_billing]"]');
        if (box.hasClass('shipping')) {
          shipping.val(id);
          boxName = 'shippingAddress';

        } else {
          billing.val(id);
          boxName = 'billingAddress';
        }

        // Set 'same-as-billing' state
        var shippingField = jQuery('.inline-field.profile-shippingAddress');
        if (shipping.val() == billing.val()) {
          shippingField.addClass('same-as-billing');
          same.val('1');

        } else {
          shippingField.removeClass('same-as-billing');
          same.val('');
        }

        // Set text fields
        jQuery(this).find('li').each(
          function() {
            var elm = jQuery(this);
            jQuery('.profile-' + boxName + ' .address-' + elm.data('name') + ' .address-field').html(elm.find('.address-text-value').html());
          }
        );

        jQuery('.order-info form').change();

        popup.destroy();
      }
    );
  }
);
