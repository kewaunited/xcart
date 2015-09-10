/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * NextPreviousProduct product page cookie setter
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var nextPreviousLinkHoverHandler = function()
{
    $(this).find('.next-previous-dropdown').fadeIn(200);
}

var nextPreviousLinkUnhoverHandler = function()
{
    $(this).find('.next-previous-dropdown').fadeOut(200);
}

$(document).ready(function(){
    $('.next-previous-link').hover(nextPreviousLinkHoverHandler, nextPreviousLinkUnhoverHandler);

    $('.next-previous-link a').click(function(){
        var date = new Date();
        date.setTime(date.getTime()+30*60*1000);
        var expires = "; expires="+date.toUTCString();
        var path = '';

        var box = $(this).parents('.next-previous-link').find('.next-previous-cookie-data').eq(0);

        var productId = box.data('xcProductId');
        var dataString = box.data('xcNextPrevious');

        if (box.data('xcCookiePath')) {
            path = '; path=' + box.data('xcCookiePath');
        }

        document.cookie = 'xc_np_product_' + productId + '=' + JSON.stringify(dataString) + path + expires;
    });
});
