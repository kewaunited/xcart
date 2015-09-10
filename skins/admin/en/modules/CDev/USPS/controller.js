/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * USPS settings page controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    jQuery('#use-cod-price-setting').change(
      function () {

        var codPriceBox = jQuery('tr.cod-price').get(0);

        if (codPriceBox) {

          if (this.checked) {
            jQuery(codPriceBox).show();

          } else {
            jQuery(codPriceBox).hide();
          }
        }
      }
    );
  }
);
