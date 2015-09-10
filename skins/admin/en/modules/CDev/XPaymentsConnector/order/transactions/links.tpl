{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Links for XPC payment transaction 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="xpc-link">
  <a class="dotted" href="javascript: void(0);" onclick="javascript: showAddInfo({getOrderNumber()}, {getTransactionId(entity)});">{t(#View payment information#)}</a><br/>
  <a href="{getPaymentURL(entity)}" target="blank">{t(#Go to payment details page#)}</a>
</div>
