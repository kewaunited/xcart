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
    pattern: '.inline-field.inline-textarea',
    handler: function () {

      var field = jQuery(this);

      var inputs = jQuery('.field :input', this);

      // Sanitize-and-set value into field
      this.sanitize = function()
      {
        inputs.each(
          function () {
            this.value = this.value.replace(/^ +/, '').replace(/ +$/, '');
          }
        );
      }

      var getViewValueElements = this.getViewValueElements;
      this.getViewValueElements = function()
      {
        return getViewValueElements.apply(this).find('.value');
      }

    }
  }
);
