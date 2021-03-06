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
    pattern: '.inline-field.inline-popup',
    handler: function () {

      var field = jQuery(this);

      this.loadPopup = function()
      {
        popup.load(this.getPopupURL());
      }

      this.getPopupURL = function()
      {
        return field.data('popup-url');
      }

      field
        .find('.view')
        .click(_.bind(this.loadPopup, this));

      var inputs = jQuery('.field :input', this);

      // Sanitize-and-set value into field
      this.sanitize = function()
      {
      }

      // Save field into view
      this.saveField = function()
      {
      }

    }
  }
);
