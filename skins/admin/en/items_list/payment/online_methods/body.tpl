{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list widget for popup
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="payments-list {getListCSSClasses()}">
  <li FOREACH="getPageData(),id,payment" class="item-row line">
    <ul class="payment-method-entry">
      <li class="title-row module-name-{payment.getModuleName()}">
        <widget template="items_list/payment/online_methods/list.tpl" />
        <div class="clearfix"></div>
      </li>
    </ul>
  </li>
</ul>
