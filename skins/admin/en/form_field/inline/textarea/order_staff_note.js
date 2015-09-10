/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Price field controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonForm.elementControllers.push(
  {
    pattern: '.inline-field.inline-order-staff-note',
    handler: function () {

      var field = jQuery(this);

      field.find('.field button').click(
        _.bind(
          function(event) {
            this.endEdit();

            return false;
          },
          this
        )
      );

      field.find('.field .close').click(
        _.bind(
          function(event) {
            this.endEdit(true);

            return false;
          },
          this
        )
      );

      this.isProcessBlur = function()
      {
        return false;
      }

      field.bind(
        'afterSaveFieldInline',
        function(event, data) {
          if (data.value) {
            field.removeClass('empty').addClass('filled');

          } else {
            field.removeClass('filled').addClass('empty');
            this.getViewValueElements().html(field.find('.value').data('empty'));
          }
        }
      );

      field.bind(
        'saveEmptyFieldInline',
        function(event) {
          field.removeClass('filled').addClass('empty');
          this.getViewValueElements().html(field.find('.value').data('empty'));
        }
      );

      field.bind(
        'afterSaveFieldInline',
        function(event) {
          var form = field.parents('form');
          form.get(0).commonController.enableBackgroundSubmit();
          form.submit();
        }
      );

      field.bind(
        'beforeStartEditInline',
        function(event) {
          this.lastWidth = jQuery('.view', this).outerWidth();
        }
      );

      field.bind(
        'startEditInline',
        function(event) {
          var box = jQuery('.field', this);
          var w = box.outerWidth();
          box.css('margin-right', (this.lastWidth - w - 4) + 'px')
        }
      );

    }
  }

);
