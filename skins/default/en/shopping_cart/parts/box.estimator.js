/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Shipping estimator box widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/**
 * Shipping estimator box widget
 */

function ShippingEstimateBox(base)
{
  var args = Array.prototype.slice.call(arguments, 0);
  if (!base) {
    args[0] = '.estimator';
  }

  this.bind('local.loaded', _.bind(this.triggerNeedCart, this));

  this.callSupermethod('constructor', args);

  if (this.base.data('deferred')) {
    this.load();
  }
}

extend(ShippingEstimateBox, ALoadable);

// Shade widget
ShippingEstimateBox.prototype.shadeWidget = true;

// Update page title
ShippingEstimateBox.prototype.updatePageTitle = false;

// Widget target
ShippingEstimateBox.prototype.widgetTarget = 'cart';

// Widget class name
ShippingEstimateBox.prototype.widgetClass = '\\XLite\\View\\ShippingEstimateBox';


ShippingEstimateBox.prototype.triggerNeedCart = function()
{
  core.trigger('reassignEstimator', this);
};

// Get event namespace (prefix)
ShippingEstimateBox.prototype.getEventNamespace = function()
{
  return 'cart.shippingestimate';
};

// Load after page load
core.autoload(ShippingEstimateBox);