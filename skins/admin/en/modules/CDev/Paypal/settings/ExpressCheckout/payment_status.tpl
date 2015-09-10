{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="payment_status.after.ExpressCheckout", weight="100")
 *}
{if:!paymentMethod.isConfigured()}
{t(#Don't have account yet?#)}
  {if:isInContextSignUpAvailable()}
  <a href="{getSignUpUrl()}" target="PPFrame" data-paypal-button="true">{t(#Sign Up Now#)}</a>
  {else:}
  <a href="{getSignUpUrl()}" target="_blank">{t(#Sign Up Now#)}</a>
  {end:}
{end:}