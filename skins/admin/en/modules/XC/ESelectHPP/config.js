/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'eselect-help-switcher',
  '.eselect',
  function() {
    jQuery('.eselect-webhook .url').click(
      function(event) {
        if (document.selection) {
          var range = document.body.createTextRange();
          range.moveToElementText(event.currentTarget);
          range.select();
   
        } else if (window.getSelection) {
          var range = document.createRange();
          range.selectNode(event.currentTarget.childNodes[0]);
          window.getSelection().addRange(range);
        }

      }
    );
  }
);
