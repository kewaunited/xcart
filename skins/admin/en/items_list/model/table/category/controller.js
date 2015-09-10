/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Category page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'category-page-controller',
  'body.target-categories',
  function ()
  {
    if (self.location.search.search(/add_new=1/) != -1) {
      setTimeout(
        function() {
          jQuery('.items-list.categories button.create-inline').click();
        },
        500
      );
    }
  }
);
