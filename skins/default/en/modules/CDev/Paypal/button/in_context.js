/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Paypal In-Context checkout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

(function(d, s, id){
  var js, ref = d.getElementsByTagName(s)[0];
  if (!d.getElementById(id)){
    js = d.createElement(s); js.id = id; js.async = true;
    js.src = "//www.paypalobjects.com/js/external/paypal.v1.js";
    ref.parentNode.insertBefore(js, ref);
  }
}(document, "script", "paypal-js"));

var paypalExpressCheckout = function (element, isAdd2Cart, url) {
  popup.close();

  if (isAdd2Cart) {
    element.commonController.backgroundSubmit = false;
    jQuery(element).removeAttr('onsubmit');
    element['expressCheckout'].value = 1
  }

  PAYPAL.apps.Checkout.startFlow(url);
  element.target = "PPFrame";

  setTimeout(function () {
    if (isAdd2Cart) {
      element.commonController.backgroundSubmit = true;
      jQuery(element).attr('onsubmit', 'javascript: return false;');
      element['expressCheckout'].value = 0;
    }
    element.target = "";
  }, 500);

  var t = setInterval(function () {
    if (!PAYPAL.apps.Checkout.isOpen()) {
      clearInterval(t);
      jQuery('body').removeClass('PPFrame');
    }
  }, 500);

  return true;
};
