/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Order history box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function OrderEventDetails(base)
{
  this.callSupermethod('constructor', arguments);
}

extend(OrderEventDetails, ALoadable);

OrderEventDetails.prototype.widgetTarget = 'order';

OrderEventDetails.prototype.widgetClass = '\\XLite\\View\\Minicart';

OrderEventDetails.prototype.base = '.order-history';

OrderEventDetails.autoload = function()
{
  new OrderEventDetails(jQuery('.order-history'));
}

OrderEventDetails.prototype.postprocess = function(isSuccess, initial)
{
  ALoadable.prototype.postprocess.apply(this, arguments);

  if (isSuccess && initial) {
    jQuery('.order-info .title-box .history a').click(_.bind(this.handleSwitch, this));
  }

  if (isSuccess) {
    this.base.find('.action i').click(
      function () {
        var elm = jQuery(this);
        if (elm.hasClass('fa-plus-square-o')) {
          elm.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');

        } else {
          elm.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        }
      }
    );
  }
}

OrderEventDetails.prototype.handleSwitch = function(event)
{
  if (this.base.hasClass('in')) {
    this.base.collapse('hide');

  } else {
    this.base.collapse('show');
  }

  return false;
}

OrderEventDetails.prototype.getParams = function(params)
{
  params = ALoadable.prototype.getParams.apply(this, arguments);

  params['orderNumber'] = this.base.data('orderNumber');

  return params;
}

core.autoload('OrderEventDetails');
