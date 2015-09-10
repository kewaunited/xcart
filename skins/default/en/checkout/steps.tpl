{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Steps block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="steps clearfix">

  <div
    FOREACH="getSteps(),stepKey,step"
    class="step
      {stepKey}-step
      {if:!isEnabledStep(step)}disabled{end:}
      {if:hasLeftArrow(step)}left-arrow{end:}
      {if:hasRightArrow(step)}right-arrow{end:}
    ">
    <div class="step-title">
      <img src="images/spacer.gif" class="arrow left" alt="" IF="hasLeftArrow(step)" />
      <span class="text">{t(step.getTitle())}</span>
      <img src="images/spacer.gif" class="arrow right" alt="" IF="hasRightArrow(step)" />
    </div>
    <div class="step-box clearfix">{step.display()}</div>
  </div>

</div>
