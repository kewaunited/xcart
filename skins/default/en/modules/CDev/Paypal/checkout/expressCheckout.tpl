{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method row
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="payment-title">{method.getTitle()}</span>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside" target="_blank" class="paypal-ec">What is PayPal?</a>
<div IF="method.getDescription()" class="payment-description">{method.getDescription()}</div>