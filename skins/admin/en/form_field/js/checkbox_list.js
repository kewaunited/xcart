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
      return 0 < this.$element.filter('select.checkbox-list').length;
    },
    handler: function () {
      var options = {
        minWidth: this.$element.width(),
        header: false,
        noneSelectedText: this.$element.data('placeholder'),
        selectedList: 2,
        close: function() {
          showCheckboxListValues(this);
        },
        height: 10 < this.$element.find('options').length ? 250 : 'auto'
      };

      if (this.$element.data('none-selected-text')) {
        options.noneSelectedText = this.$element.data('none-selected-text');
      }

      if (this.$element.data('selected-text')) {
        options.selectedText = this.$element.data('selected-text');
      }

      if (this.$element.data('header')) {
        options.header = true;

      } else if (this.$element.data('filter')) {
        options.header = 'close';
      }

      if (this.$element.data('filter')) {
        options.classes = 'ui-multiselect-with-filter';
      }

      this.$element.after('<div class="checkbox-list-values"></div>');
      this.$element.multiselect(options);
      showCheckboxListValues(this.$element);

      if (this.$element.data('filter')) {
        options = {placeholder: this.$element.data('filter-placeholder')};

        this.$element.multiselectfilter(options);

        jQuery('.ui-multiselect-filter').each(
          function () {
            if (3 == this.childNodes[0].nodeType) {
              this.removeChild(this.childNodes[0]);
            }
          }
        );
      }
    }
  }
);

function showCheckboxListValues(elem) {
  var value = '';
  if (2 < jQuery(elem).find('option:selected').length) {
    value = jQuery(elem).find('option:selected').map(function() { return jQuery(this).text(); }).get().join(', ');
  }
  jQuery(elem).parent().find('div.checkbox-list-values').text(value);;
}
