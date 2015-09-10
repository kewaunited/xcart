/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Script
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(
  function() {
    jQuery('textarea.codemirror').each(function () {
      var self = this;
      var element = jQuery(self);
      var mode = jQuery(this).data('codemirrorMode');

      var width = element.outerWidth();
      var height = element.outerHeight();

      var editor = CodeMirror.fromTextArea(
        self,
        {
          mode: mode,
          lineNumbers : true,
          viewportMargin: Infinity
        }
      );
      editor.setSize(width, height);

      editor.on('change', function (editor) {
        jQuery(self).text(editor.doc.getValue()).trigger('change');
      });

    });
  }
);
