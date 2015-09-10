/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * JS-controller for Prepare update step
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function ReValidateKeys () {
  this.button = jQuery('.revalidate-keys button');

  var self = this;
  this.button.click(function () {
    self.sendRequest();
  })
}

ReValidateKeys.prototype.sendRequest = function () {
  core.post(
    {
      target: 'upgrade',
      action: 'validate_keys'
    },
    _.bind(this.success, this)
  );
};

ReValidateKeys.prototype.success = function () {
  this.button.get(0).progressState.setStateSuccess();
  location.reload();
};

core.autoload(ReValidateKeys)
