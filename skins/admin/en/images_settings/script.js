/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Images settings page js controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(function() {
   jQuery(".preview").each(function() {
     var img = jQuery(this).data('img');
     if (img) {
       jQuery(this).tooltip({
        title : '<img src="' + xliteConfig.base_url  + 'skins/admin/en/images/' + img + '" />',
        html: true,
        placement: 'bottom',
        delay: { show: 100, hide: 400 },
       });
     }
   });

   jQuery('.sticky-panel.images-settings-panel .button-tooltip button').click(function(event) {

     var submitButton = jQuery('.sticky-panel.images-settings-panel button.submit').get(0);
     var proceed = true;

     if (!jQuery(submitButton).prop('disabled')) {
       proceed = confirm(core.t('There are unsaved changes on the page. If you choose to continue, these changes will be lost. Do you want to proceed?'));
     }

     if (proceed) {
       self.location = jQuery(this).data('url');

     } else {
       event.stopImmediatePropagation();
     }
   });
});
