/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function CleanURLSwitcher () {
  jQuery('#clean-url-flag').change(function (event)
  {
    event.stopImmediatePropagation();

    core.get(
      URLHandler.buildURL({
        target: 'settings',
        page: 'Environment',
        action: 'switch_clean_url'
      })
    ).done(function(data) {
      if (false === data['Success']) {
        jQuery('.clean-url-setting-error-msg').html(data['Error']['msg']);
        jQuery('.clean-url-setting-error-body').html(data['Error']['body']);
        $('#clean-url-flag').prop('checked', false);
      }else{
        jQuery('.clean-url-setting-error-msg').html('&nbsp;');
        jQuery('.clean-url-setting-error-body').html('&nbsp;');        
        core.trigger('message', {
          type: 'info',
          message: data['NewState'] ? core.t('Clean URLs are enabled') : core.t('Clean URLs are disabled')
        });
      }
      //'Clean URLs functionality may not be enabled. More info');
    });

    return false;
  });
}

core.autoload(CleanURLSwitcher);