/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * PayPal model page controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    jQuery('.general-settings .model-properties ul.table li.select-protocol div.table-value .toggle-edit').click(
      function() {
        jQuery('.general-settings .model-properties ul.table li.select-protocol div.table-value .view').toggle();
        jQuery('.general-settings .model-properties ul.table li.select-protocol div.table-value .value').toggle();
      }
    );
  }
);
