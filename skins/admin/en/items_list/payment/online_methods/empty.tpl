{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="no-payment-methods-appearance">
  <div class="box">
    <div class="no-payments-found">{getNoPaymentMethodsFoundMessage()}</div>
    <div IF="getParam(#country#)" class="no-payments-found">{t(#Try to search worldwide or find the needed solution in marketplace#,_ARRAY_(#URL#^buildURL(#addons_list_marketplace#,##,_ARRAY_(#tag#^#Payment processing#,#substring#^getParam(#substring#))))):h}</div>
    <div IF="!getParam(#country#)" class="no-payments-found">{t(#Try to change the search criteria or find the needed solution in marketplace#,_ARRAY_(#URL#^buildURL(#addons_list_marketplace#,##,_ARRAY_(#tag#^#Payment processing#,#substring#^getParam(#substring#))))):h}</div>
</div>
