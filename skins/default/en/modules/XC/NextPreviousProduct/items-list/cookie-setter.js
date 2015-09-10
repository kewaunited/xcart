/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * NextPreviousProduct items list cookie setter
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.bind(
  'list.products.postprocess',
  function(event, data) {
    data.widget.base
      .find('.product-cell a')
      .not('.quicklook-link')
      .not('.next-previous-assigned')
      .off('click')
      .click(
        function(event) {
          var date = new Date();
          date.setTime(date.getTime() + 30 * 60 * 1000);
          var expires = "; expires=" + date.toUTCString();
          var path = '';

          var box = jQuery(this).parents('.product-cell').find('.next-previous-cookie-data').eq(0);

          var productId = box.data('xcProductId');
          var dataString = box.data('xcNextPrevious');

          if (box.data('xcCookiePath')) {
            path = '; path=' + box.data('xcCookiePath');
          }

          document.cookie = 'xc_np_product_' + productId + '=' + JSON.stringify(dataString) + path + expires;
        }
      )
      .addClass('next-previous-assigned');
  }
);
