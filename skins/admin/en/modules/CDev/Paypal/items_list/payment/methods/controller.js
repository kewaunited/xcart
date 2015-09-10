/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Common items list controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

// Payment methods switch loaded event
core.bind(
  'payment.methods.switch.loaded',
  function (event, data)
  {
    if (data.data.responseJSON && data.data.responseJSON.href) {
      if ('CDev_Paypal' === data.switcher.closest('.cell').data('module-name')) {
        core.trigger('payment.methods.list.reload');
      }
    }
  }
);

// Payment methods remove loaded event
core.bind(
  'payment.methods.remove.loaded.started',
  function (event, data)
  {
    if ('CDev_Paypal' === data.line.data('module-name')) {
      data.line.donotRemove = true;
      core.trigger('payment.methods.list.reload');
    }
  }
);

core.bind(
  'payment.methods.list.reload',
  function (event, data) {
    core.get(
      URLHandler.buildURL({target: 'payment_settings', action: '', widget: '\\XLite\\View\\Payment\\Configuration'}),
      function(xhr, status, data) {
        var paymentConf = jQuery(data).find('.payment-conf');
        if (paymentConf.length > 0) {
          jQuery('.payment-conf').html(paymentConf.html());
          core.microhandlers.runAll();
          core.autoload(PopupButtonAddPaymentMethod);
        }
      }
    );
  }
);
