/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * RSS feed controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function LazyLoadWidget(base)
{
  this.callSupermethod('constructor', arguments);

  this.widgetClass = jQuery(base).data('lazyClass');

  jQuery(_.bind(this.load, this, {}));
}

extend(LazyLoadWidget, ALoadable);

LazyLoadWidget.prototype.reloadIfError = false;

LazyLoadWidget.prototype.shadeWidget = false;

LazyLoadWidget.autoload = function() {
  jQuery('.lazy-load.active').each(function () {
    new LazyLoadWidget(this);
  });
};

core.autoload('LazyLoadWidget');
