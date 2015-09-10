/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Print invoice button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function ProgressStateButton (element) {
  this.element = element;
  this.timer = null;
  this.isContinuous = jQuery(element).hasClass('continuous')
}

ProgressStateButton.autoload = function () {
  jQuery('.btn.progress-state').each(
    function () {
      if (!this.progressState) {
        var progressState = new ProgressStateButton(this);

        this.progressState = progressState;

        jQuery(this).click(function () {
          progressState.setStateInProgress();
        });
      }
    }
  );
};

ProgressStateButton.prototype.setState = function (state) {
  clearTimeout(this.timer);

  this.clearState();
  jQuery(this.element).toggleClass(state, true);
};

ProgressStateButton.prototype.clearState = function () {
  this.setEnabled();

  jQuery(this.element).removeClass('still')
    .removeClass('in_progress')
    .removeClass('success')
    .removeClass('fail');
};

ProgressStateButton.prototype.setStateStill = function () {
  this.setState('still');
};

ProgressStateButton.prototype.setStateInProgress = function () {
  this.setState('in_progress');

  this.setDisabled();
};

ProgressStateButton.prototype.setStateSuccess = function () {
  this.setState('success');

  if (this.isContinuous) {
    this.timer = setTimeout(
      _.bind(
        function () {
          this.setStateStill()
        },
        this)
      , 5000
    );
  } else {
    this.setDisabled();
  }
};

ProgressStateButton.prototype.setStateFail = function () {
  this.setState('fail');
};

ProgressStateButton.prototype.setDisabled = function () {
  jQuery(this.element).toggleClass('disabled', true);
};

ProgressStateButton.prototype.setEnabled = function () {
  jQuery(this.element).toggleClass('disabled', false);
};

core.autoload(ProgressStateButton);

core.microhandlers.add(
  'ProgressStateButton',
  '.btn.progress-state',
  function (event) {
    core.autoload(ProgressStateButton);
  }
);
