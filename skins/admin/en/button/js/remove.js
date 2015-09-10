/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Remove button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonForm.elementControllers.push(
  {
    pattern: '.line .actions .remove-wrapper',
    handler: function () {

      jQuery('button.remove', this).click(
        function () {
          jQuery(this).parents('.remove-wrapper').eq(0).find('input').click();
        }
      );

      jQuery('input', this).eq(0).change(
        function () {
          var inp = jQuery(this);
          var btn = inp.parents('.remove-wrapper').eq(0).find('button.remove');
          var cell = inp.parents('.line').eq(0);

          if (inp.is(':checked')) {
            btn.addClass('mark');
            cell.addClass('remove-mark');

          } else {
            btn.removeClass('mark');
            cell.removeClass('remove-mark');
          }

          cell.parents('form').change();
        }
      );
    }
  }
);
