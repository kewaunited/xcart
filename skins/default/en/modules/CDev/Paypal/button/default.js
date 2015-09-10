/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Paypal In-Context checkout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var paypalExpressCheckout = function (element, isAdd2Cart) {
  if (isAdd2Cart) {
    element.commonController.backgroundSubmit = false;
    $(element).removeAttr('onsubmit');
    element['expressCheckout'].value = 1
  }

  return true;
};
