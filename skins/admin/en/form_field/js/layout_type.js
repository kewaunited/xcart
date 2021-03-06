/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Layout type controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function LayoutType() {
  var o = this;

  o.base = jQuery('.layout-types:first');
  o.base.commonController = o;

  o.selector = jQuery('.hidden-field select', o.base);

  jQuery('.layout-type', this.base).bind('click', _.bind(o.handleClickLayoutType, o));
  o.selector.bind('change', _.bind(o.handleChange, o));
}

LayoutType.prototype.base = null;
LayoutType.prototype.selector = null;

LayoutType.prototype.handleChange = function (event, data) {
  var o = this;
  var preview = jQuery('.layout-settings .preview img');

  assignWaitOverlay(o.base);
  assignShadeOverlay(preview);

  core.get(
    URLHandler.buildURL({
      target: 'layout',
      action: 'change_layout',
      layout_type: data.layoutType
    }),
    function () {
      preview.attr('src', data.layoutPreview);
      unassignWaitOverlay(o.base);
      unassignShadeOverlay(preview);
    }
  );
};

LayoutType.prototype.handleClickLayoutType = function (event) {
  jQuery('.layout-type', this.base).removeClass('selected');
  var selected = jQuery(event.currentTarget).addClass('selected');
  this.setLayoutType(selected.data());
};

LayoutType.prototype.setLayoutType = function (data) {
  this.selector.val(data.layoutType);
  this.selector.trigger('change', data);
};

core.autoload(LayoutType);
