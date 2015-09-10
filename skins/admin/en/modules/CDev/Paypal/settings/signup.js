/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * PayPal In-Constext Boarding SignUp
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
    js.src = "https://www.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js";

    ref.parentNode.insertBefore(js, ref);
  }
}(document, "script", "paypal-js"));
