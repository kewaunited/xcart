{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * List of X-Payments payments. Here are called as transactions. 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 *}

<div IF="isFraudStatus(entity)">

<p class="alert alert-warning">
  <strong>{t(#Warning#)}!</strong>
  {t(#X-Payments considers this transaction as potentially fraudlent.#)}
</p>

<a class="btn regular-button" href="{buildURL(#order#,#accept#,_ARRAY_(#order_number#^order.getOrderNumber(),#trn_id#^getTransactionId(entity)))}">{t(#Accept#)}</a>

<a class="btn regular-button" href="{buildURL(#order#,#decline#,_ARRAY_(#order_number#^order.getOrderNumber(),#trn_id#^getTransactionId(entity)))}">{t(#Decline#)}</a>

</div>
