/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Header search box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'header-search',
  '.header-search',
  function() {
    var base = jQuery(this);

    base.find('.dropdown-menu li a').click(
      function () {
        var a = jQuery(this);
        base.find('input[name="substring"]').attr('placeholder', a.data('placeholder'));
        base.find('input[name="code"]').val(a.data('code'));
        base.find('input[name="substring"]')
          .click()
          .focus();

        return false;
      }
    );
  }
);

