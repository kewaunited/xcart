/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Functions for Amazon Payments Advanced module
 *
 */

core.bind('afterPopupPlace', function() {
  func_amazon_pa_put_button('payWithAmazonDiv_add2c_popup_btn');
  func_amazon_pa_put_button('payWithAmazonDiv_mini_cart_btn');
});

core.bind('cart.main.loaded', function() {
  func_amazon_pa_put_button('payWithAmazonDiv_cart_btn');
});

core.bind('minicart.loaded', function() {
  func_amazon_pa_put_button('payWithAmazonDiv_mini_cart_btn');
});

$(document).ready(function() {

  func_amazon_pa_put_button('payWithAmazonDiv_cart_btn');
  func_amazon_pa_put_button('payWithAmazonDiv_co_btn');
  func_amazon_pa_put_button('payWithAmazonDiv_mini_cart_btn');

  // detect checkout page
  if ($('#addressBookWidgetDiv').length > 0 && AMAZON_PA_CONST.SID) {
    func_amazon_pa_init_checkout();
  }

});

function func_amazon_pa_lock_checkout(lock) {
  if (lock) {
    $('button.place-order').addClass('disabled');
  } else {
    $('button.place-order').removeClass('disabled');
  }
}

function func_amazon_pa_block_elm(elm_sel, block) {
  // $(elm_sel).block(); - does not work anymore, no blockUI
  // $(elm_sel).get(0).loadable.shade();
  // TODO: use shade/unshade

  // simple hash for id
  var bl_div_id = 'bl_div_' + elm_sel.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);
  if (block) {
    var bl_div = $('<div class="wait-block-overlay" id="'+bl_div_id+'"><div class="wait-block"><div></div></div></div>');
    var ofs = $(elm_sel).offset();
    bl_div
      .css('width', $(elm_sel).width())
      .css('height', $(elm_sel).height())
      .css('left', ofs.left)
      .css('top', ofs.top)
      .css('z-index', '1010')
      .appendTo('body');
  } else {
    $('#'+bl_div_id).remove();
  }
}

function func_amazon_pa_check_address(orefid) {

  func_amazon_pa_lock_checkout(true);
  func_amazon_pa_block_elm('div.shipping-step', true);

  $.post('cart.php?target=amazon_checkout', {'mode': 'check_address', 'orefid': orefid}, function(data) {

    if (data == 'error') {
      alert('ERROR: Amazon server communication error. Please check module configuration (see logs for details)');
    }

    // update shippings list
    var ship_block = 'div.step-shipping-methods';
    $.get('cart.php?target=checkout&widget=\\XLite\\View\\Checkout\\ShippingMethodsList&_='+Math.random(), function(data) {

      $(ship_block).html($(data).html());

      // see checkout/steps/shipping/parts/shippingMethods.js
      if ($(ship_block).find("input[name='methodId']").length > 0 || $(ship_block).find("select[name='methodId']").length > 0) {

        $(ship_block).find("input[name='methodId']").change(function() {
          func_amazon_pa_on_change_shipping();
        });
        $(ship_block).find("select[name='methodId']").change(function() {
          func_amazon_pa_on_change_shipping();
        });

        amazon_pa_address_selected = true;
      } else {
        amazon_pa_address_selected = false;
      }

      func_amazon_pa_check_checkout_button();

      func_amazon_pa_block_elm('div.shipping-step', false);

    });

    // update totals and place order button
    func_amazon_pa_refresh_totals();

  });
}

function func_amazon_pa_refresh_totals() {

    func_amazon_pa_block_elm('div.review-step', true);

    // update cart totals section
    $.get('cart.php?target=checkout&widget=\\XLite\\View\\Checkout\\CartItems&_='+Math.random(), function(data) {

      $('div.cart-items').html($(data).find('div').eq(0).html());

      func_amazon_pa_block_elm('div.review-step', false);

      $('div.cart-items div.items-row a').click(function() {
        $('div.cart-items div.list').toggle();
        return false;
      });

    });

    // update place order button
    $.get('cart.php?target=checkout&widget=\\XLite\\View\\Button\\PlaceOrder&_='+Math.random(), function(data) {

      $('div.button-row').html($(data).html());

      $('button.place-order').click(function() {
        func_amazon_pa_place_order();
      });

      func_amazon_pa_check_checkout_button();
    });
}

function func_amazon_pa_check_payment(orefid) {
  amazon_pa_payment_selected = true;
  func_amazon_pa_check_checkout_button();
}

function func_amazon_pa_check_checkout_button() {
  if (amazon_pa_payment_selected && amazon_pa_address_selected) {
    // enable place order button
    func_amazon_pa_lock_checkout(false);
    amazon_pa_place_order_enabled = true;
  } else {
    func_amazon_pa_lock_checkout(true);
    amazon_pa_place_order_enabled = false;
  }
}

function func_amazon_pa_on_change_shipping() {

  var new_sid = $('div.step-shipping-methods').find("input[type='radio']:checked").val();
  if (!new_sid) {
    new_sid = $('div.step-shipping-methods').find("select[name='methodId']").val();
  }
  if (new_sid) {
    func_amazon_pa_block_elm('div.shipping-step', true);
    $.post('cart.php?target=checkout', {'action': 'shipping', 'methodId': new_sid}, function(data) {

      func_amazon_pa_block_elm('div.shipping-step', false);

      func_amazon_pa_refresh_totals();
    });
  }
}

function func_amazon_pa_place_order() {

  if (!amazon_pa_place_order_enabled) {
    return false;
  }

  // prevent double submission
  amazon_pa_place_order_enabled = false;

  // submit form
  func_amazon_pa_block_elm('body', true);
  var co_form = $('div.review-step form.place');
  co_form.removeAttr('onsubmit');
  co_form.attr('action', 'cart.php?target=amazon_checkout');
  co_form.find("input[name='target']").val('amazon_checkout');
  co_form.append('<input type="hidden" name="amazon_pa_orefid" value="'+amazon_pa_orefid+'" />');
  co_form.append('<input type="hidden" name="mode" value="place_order" />');
  return true;
}

function func_amazon_pa_init_checkout() {

  if ($.blockUI) {
    $.blockUI.defaults.baseZ = 200000;
  }

  // except mobile
  if ($('button.place-order').length > 0 && AMAZON_PA_CONST.SID && !AMAZON_PA_CONST.MOBILE) {

    func_amazon_pa_lock_checkout(true);

    // place order button 
    $('button.place-order').click(function() {
      func_amazon_pa_place_order();
    });

    // have coupon link
    $('div.coupons div.new a').click(function() {
      $('div.coupons div.add-coupon').toggle();
      return false;
    });

    // tmp fix for pre-selected payment method
    $('.payment-tpl').remove();
  }

  new OffAmazonPayments.Widgets.AddressBook({
    sellerId: AMAZON_PA_CONST.SID,
    amazonOrderReferenceId: amazon_pa_orefid,

    onAddressSelect: function(orderReference) {
      func_amazon_pa_check_address(amazon_pa_orefid);
    },

    design: {
      size : {width:'400px', height:'260px'}
    },

    onError: function(error) {
      if (AMAZON_PA_CONST.MODE == 'test') {
        alert("Amazon AddressBook widget error: code="+error.getErrorCode()+' msg='+error.getErrorMessage());
      }
    }

  }).bind("addressBookWidgetDiv");

  new OffAmazonPayments.Widgets.Wallet({
    sellerId: AMAZON_PA_CONST.SID,
    amazonOrderReferenceId: amazon_pa_orefid,

    design: {
      size : {width:'400px', height:'260px'}
    },

    onPaymentSelect: function(orderReference) {
      func_amazon_pa_check_payment(amazon_pa_orefid);
    },

    onError: function(error) {
      if (AMAZON_PA_CONST.MODE == 'test') {
        alert("Amazon Wallet widget error: code="+error.getErrorCode()+' msg='+error.getErrorMessage());
      }
    }
  }).bind("walletWidgetDiv");

}

function func_amazon_pa_put_button(elmid) {

  // element not found
  if ($('#'+elmid).length <= 0) {
    return;
  }

  // button already created
  if ($('#'+elmid).data('amz_button_placed')) {
    return;
  }
  $('#'+elmid).data('amz_button_placed', true);

  new OffAmazonPayments.Widgets.Button({
    sellerId: AMAZON_PA_CONST.SID,
    useAmazonAddressBook: true,
    onSignIn: function(orderReference) {
      var amazonOrderReferenceId = orderReference.getAmazonOrderReferenceId();
      window.location = 'cart.php?target=amazon_checkout&amz_pa_ref=' + amazonOrderReferenceId;
    },
    onError: function(error) {
      if (AMAZON_PA_CONST.MODE == 'test') {
        alert("Amazon put button widget error: code="+error.getErrorCode()+' msg='+error.getErrorMessage());
      }
    }
  }).bind(elmid);
}
