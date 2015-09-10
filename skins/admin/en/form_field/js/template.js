/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Template selector controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function TemplatesSelector() {
  var o = this;

  o.base = jQuery('.templates:first');
  o.base.commonController = o;

  o.selector = jQuery('.hidden-field select', o.base);

  jQuery('.template', o.base).bind('click', _.bind(o.handleClickTemplate, o));
  jQuery('.template.marked', o.base).addClass('active');

  jQuery('button.submit', o.base.closest('form')).bind('click', function (e) {
    if (jQuery('.template.checked', o.base).data('is-redeploy-required') == 1
      && !confirm(core.t('To make your changes visible in the customer area, cache rebuild is required. It will take several seconds. You don’t need to close the storefront, the operation is executed in the background.'))
    ) {
      e.stopPropagation();
      e.preventDefault();

      return false;
    }
  });
}

TemplatesSelector.prototype.base = null;
TemplatesSelector.prototype.selector = null;

TemplatesSelector.prototype.handleClickTemplate = function (event) {
  jQuery('.template', this.base).removeClass('checked');
  this.setTemplate(jQuery(event.currentTarget).addClass('checked').data('template-id'));
  var settingsWidget = jQuery('.layout-settings.settings');
  if (this.selector.parents('form').get(0).isChanged()) {
    assignShadeOverlay(settingsWidget);
  } else {
    unassignShadeOverlay(settingsWidget);
  }
};

TemplatesSelector.prototype.setTemplate = function (template) {
  this.selector.val(template);
  this.selector.trigger('change');
};

core.autoload(TemplatesSelector);
