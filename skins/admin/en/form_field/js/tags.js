/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Multiselect microcontroller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return 0 < this.$element.filter('select.tags').length;
    },
    handler: function () {
      this.$element.data('jqv', {validateNonVisibleFields: true});
      this.$element.chosen();
      this.$element.next('.chosen-container').css('min-width', this.$element.width());

      this.$element.insertAfter(this.$element.next('.chosen-container'));

      this.$element.bind('invalid', function () {
        jQuery(this).siblings('.chosen-container').find('input').get(0).click();
      });

      jQuery('.chosen-container .search-choice').live('click', function () {
        jQuery('.search-choice-close', this).trigger('click.chosen');
        console.log(jQuery('.search-choice-close', this));
      });
   }
  }
);
