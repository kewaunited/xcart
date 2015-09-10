/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Incompatible entries list controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.bind(
  "load",
  function () {
    attachTooltip("td.status-incompatible", jQuery(".incompatible-status-message").html());
  }
);

function RequestForUpgrade () {
  this.button = jQuery('button.request-for-upgrade');

  var self = this;
  this.button.click(function () {
    self.sendRequest();
  })
}

RequestForUpgrade.prototype.sendRequest = function () {
  core.post(
    {
      target: 'upgrade',
      action: 'request_for_upgrade'
    },
    _.bind(this.success, this)
  );
};

RequestForUpgrade.prototype.success = function () {
  this.button.get(0).progressState.setStateSuccess();
};

core.autoload(RequestForUpgrade);
