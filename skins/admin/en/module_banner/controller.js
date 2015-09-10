/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Module banner controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(function () {
  jQuery('.module-banner .close-banner').bind('click', function () {
    jQuery.ajax({
      url: xliteConfig.script + "?target=main&action=close_module_banner&module=" + jQuery(this).data('module-name')
    }).done(function() {
    });

    jQuery(this).closest('.module-banner').hide();
  })
});