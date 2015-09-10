/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Date range field controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return this.$element.is('input.date-range');
    },
    handler: function() {
      var config = this.$element.data('datarangeconfig') || {};
      config.separator = ' ~ ';
      config.language = 'en';
      config.shortcuts = {
        'prev-days': [1,3,5,7],
        'prev' : ['week','month','year']
      };
      if (this.$element.data('end-date')) {
        config.endDate = this.$element.data('end-date');
      }
      this.$element.dateRangePicker(config);
    }
  }
);
