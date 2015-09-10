{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Progress state button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<button {printTagAttributes(getAttributes()):h}>
  <div class="caption">
    <span>{t(getButtonLabel())}</span>
  </div>
  <div class="loader">
    <div class="dot dot1"></div>
    <div class="dot dot2"></div>
    <div class="dot dot3"></div>
    <div class="dot dot4"></div>
  </div>
  <div class="success">
    <i class="fa fa-check"></i>
  </div>
  <div class="fail">
    <i class="fa fa-exclamation"></i>
  </div>
</button>
