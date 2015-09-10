/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Order info form controller (coupons)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function DCouponOrderView(base)
{
  this.callSupermethod('constructor', arguments);
}

extend(DCouponOrderView, ALoadable);

DCouponOrderView.autoload = function()
{
  jQuery('.coupon-row').each(
    function() {
      new DCouponOrderView(jQuery(this));
    }
  );

  var old = OrderInfoForm.prototype.isElementAffectRecalculate;
  OrderInfoForm.prototype.isElementAffectRecalculate = function(element)
  {
    return old.apply(this, arguments) && element.name != 'couponCode';
  }

  var old2 = OrderInfoForm.prototype.isNeedElementSave;
  OrderInfoForm.prototype.isNeedElementSave = function(element)
  {
    return old2.apply(this, arguments) && element.name != 'couponCode';
  }

  var old3 = OrderInfoForm.prototype.updateTotalElement;
  OrderInfoForm.prototype.updateTotalElement = function(value, name)
  {
    var result = old3.apply(this, arguments);

    if (!result && name == 'coupons') {
      _.each(
        value,
        _.bind(this.applyCoupon, this)
      );
    }

    return result;
  }

  OrderInfoForm.prototype.applyCoupon = function(cost, code)
  {
    var escapedCode = htmlspecialchars(code);

    var found = this.base.find('.coupon-row ul .code').filter(
      function() {
        return jQuery(this).html() == escapedCode;
      }
    );

    if (found.length > 0) {
      this.setPriceElement(found.parents('li').eq(0).find('.cost'), cost);
    }
  }
}

// No shade widget
DCouponOrderView.prototype.shadeWidget = false;

// Widget target
DCouponOrderView.prototype.widgetTarget = 'order';

// Widget class name
DCouponOrderView.prototype.widgetClass = '\\XLite\\Module\\CDev\\Coupons\\View\\Order\\Details\\Admin\\Modifier\\DiscountCoupon';

// Postprocess widget
DCouponOrderView.prototype.postprocess = function(isSuccess)
{
  this.callSupermethod('postprocess', arguments);

  if (isSuccess) {
    this.base.find('ul li .remove').click(_.bind(this.handleRemove, this));
    this.base.find('.add-new a.add').click(_.bind(this.handleOpenBox, this));
    this.base.find('.add-new button').click(_.bind(this.handleRedeem, this));
  }
}

DCouponOrderView.prototype.handleRemove = function(event)
{
  var line = jQuery(event.currentTarget).parents('li').eq(0);
  if (line.hasClass('remove-mark')) {
    line.removeClass('remove-mark');
    jQuery(event.currentTarget).next(':input').val('');

  } else if (line.hasClass('new')) {
    line.remove();

  } else {

    line.addClass('remove-mark');
    jQuery(event.currentTarget).next(':input').val('1');
  }

  jQuery(event.currentTarget).parents('form').change();

  return false;

}

DCouponOrderView.prototype.handleOpenBox = function(event)
{
  if (this.base.find('.add-new').hasClass('expanded')) {
    this.base.find('.add-new').removeClass('expanded');

  } else {
    this.base.find('.add-new').addClass('expanded');
    setTimeout(
      _.bind(
        function() {
          this.base.find('.add-new input').focus();
        },
        this
      ),
      100
    );
  }

  return false;
}

DCouponOrderView.prototype.handleRedeem = function(event)
{
  var code = jQuery(event.currentTarget).parents('.box').eq(0).find(':input').val();
  var escapedCode = htmlspecialchars(code);

  var duplicates = this.base.find('ul .code').filter(
    function() {
      return jQuery(this).html() == escapedCode;
    }
  );

  if (duplicates.length > 0) {
    core.trigger('message', {type: 'error', message: core.t('You have already used the coupon')});

  } else {
    core.post(
      {
        target: 'order',
        action: 'check_coupon'
      },
      null,
      {
        'target': 'order',
        'action': 'check_coupon',
        'order_number': jQuery('.order-info').data('order-number'),
        'code': code,
      },
      {
        dataType: 'json',
        success: _.bind(this.handleRedeemCallback, this)
      }
    );
  }
}

DCouponOrderView.prototype.handleRedeemCallback = function(data, status, xhr)
{
  if (!xhr.getResponseHeader('not-valid') && !data.error) {
    this.addCoupon(
      this.base.find('.add-new :input').val(),
      data.amount
    );

  } else if (data.error) {
    core.trigger('message', {type: 'error', message: data.error});
  }
}

DCouponOrderView.prototype.addCoupon = function(code, amount)
{
  var form = jQuery('form.order-operations');

  var escapedCode = htmlspecialchars(code);

  this.base.find('.add-new').removeClass('expanded');
  this.base.find('.add-new :input').val('');

  var line = this.base.find('ul li.new.hidden').clone(true)
  line.removeClass('hidden');

  line.find('input').get(0).recalculatedValue = '';
  if ('undefined' == typeof(line.find('input').get(0).commonController)) {
    new CommonElement(line.find('input').get(0));
  }

  line.find('.code').html(escapedCode);
  line.find('input').val(code);
  setPriceElement(line.find('.cost'), amount, jQuery('.order-info').data('e'));

  this.base.find('ul').append(line);

  form.change();
}

core.autoload(DCouponOrderView);

