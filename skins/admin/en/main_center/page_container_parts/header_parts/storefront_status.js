/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Storefront status js
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var StorefrontStatusView = function(base)
{
  base = base || jQuery('#header .storefront-status');

  Base.apply(this, [base]);

  this.base = base;
  this.blocked = false;

  this.initialize();
}

extend(StorefrontStatusView, Base);

StorefrontStatusView.prototype.initialize = function()
{
  this.base.find('a.toggler').click(
    _.bind(
      function(event) {
        var result = true;
        if (!this.blocked) {
          this.blocked = true;
          jQuery(this.base).addClass('disabled');
          result = core.get(jQuery(event.currentTarget).attr('href'));
          if (result) {
            this.switchState();
          }
        }

        return !result;
      },
      this
    )
  );

  core.bind('switchstorefront', _.bind(this.handleSwicthStorefront, this));
}

StorefrontStatusView.prototype.handleSwicthStorefront = function(event,data)
{
  var toggler = this.base.find('.toggler');

  if (
    (data.opened && toggler.hasClass('off'))
    || (!data.opened && toggler.hasClass('on'))
  ) {
    this.switchState();
  }

  if (data.link) {
    toggler.attr('href', data.link);
  }

  if (data.privatelink) {
    this.base.find('.link.closed a').attr('href', data.privatelink);
  }

  jQuery(this.base).removeClass('disabled');

  this.blocked = false;
}

StorefrontStatusView.prototype.switchState = function()
{
  var toggler = this.base.find('.toggler');

  if (toggler.hasClass('off')) {
    toggler.removeClass('off').addClass('on');
    this.base.removeClass('closed').addClass('opened');

  } else {
    toggler.removeClass('on').addClass('off');
    this.base.removeClass('opened').addClass('closed');
  }
}

core.autoload('StorefrontStatusView');
