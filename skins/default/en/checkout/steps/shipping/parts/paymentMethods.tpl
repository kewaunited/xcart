{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : payment step : selected state : methods
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="substep step-payment-methods">
  <div class="head-h3"><span class="bullet">{getSubstepNumber(#paymentMethods#)}</span>{t(#Payment methods#)}</div>
  <widget template="checkout/steps/shipping/parts/paymentMethodsList.tpl" />
</div>
