/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Delete address button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function ButtonDeleteAddress()
{
  var obj = this;

  jQuery('.delete-address').each(
    function () {
      var o = jQuery(this);
      var addressId = core.getCommentedData(o, 'address_id');
      var warningText = core.getCommentedData(o, 'warning_text');

      o.click(function (event) {
        result = confirm(warningText);
        if (result) {
          self.location = URLHandler.buildURL(obj.getParams(addressId));
        }
      });
    }
  );
}

ButtonDeleteAddress.prototype.getParams = function (addressId) 
{
  var result = {
    'address_id'  : addressId,
    'target'      : 'address_book',
    'action'      : 'delete'
  };
  result[xliteConfig.form_id_name] = xliteConfig.form_id;

  return result;
};

core.autoload(ButtonDeleteAddress);
