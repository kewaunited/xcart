/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add payment method JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonAddPaymentMethod()
{
  PopupButtonAddPaymentMethod.superclass.constructor.apply(this, arguments);
}

// New POPUP button widget extends POPUP button class
extend(PopupButtonAddPaymentMethod, PopupButton);

// New pattern is defined
PopupButtonAddPaymentMethod.prototype.pattern = '.add-payment-method-button';

decorate(
  'PopupButtonAddPaymentMethod',
  'callback',
  function (selector)
  {
    jQuery('.tooltip-main').each(
      function () {
        attachTooltip(
          jQuery('img', this),
          jQuery('.help-text', this).hide().html()
        );
      }
    );

    jQuery('.page-tabs .tab').click(function () {
      jQuery('.page-tabs .tab, .tab-content .body-item').removeClass('selected');
      jQuery('.page-tabs .tab').removeClass('tab-current');

      if (jQuery(this).hasClass('all-in-one-solutions')) {
        jQuery('.page-tabs .tab.all-in-one-solutions, .tab-content .body-item.all-in-one-solutions').addClass('selected');
        jQuery('.page-tabs .tab.all-in-one-solutions').addClass('tab-current');

      } else {
        jQuery('.page-tabs .tab.payment-gateways, .tab-content .body-item.payment-gateways').addClass('selected');
        jQuery('.page-tabs .tab.payment-gateways').addClass('tab-current');
      }

      jQuery('.ui-widget-overlay').css('height', jQuery(document).height());
    });

    core.autoload(TableItemsListQueue);
    SearchConditionBox();
    core.autoload(Tooltip);
    core.autoload(PopupButtonInstallAddon);
  }
);

// Autoloading new POPUP widget
core.autoload(PopupButtonAddPaymentMethod);
