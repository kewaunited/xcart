{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="{getListCSSClasses()}">

  <ul IF="getPageData()">
    {foreach:getPageData(),method}
    <li class="{getLineClass(method)}" data-module-name="{method.getModuleName()}">
    <list name="payment.methods.list.line" method="{method}" />
    </li>
    {end:}
  </ul>

</div>
