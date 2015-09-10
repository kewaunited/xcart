{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Block content : items
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="paypal.welcome.content", weight="10")
 *}
<div class="content">
  <div class="info">

    {t(#paypal_welcome_text#,_ARRAY_(#email#^getPaypalEmail())):h}

    <div class="action">
      <widget class="\XLite\Module\CDev\Paypal\View\Button\SignUp" label="{t(#Launch PayPal#)}" />
    </div>

  </div>
</div>