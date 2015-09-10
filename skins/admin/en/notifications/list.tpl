{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Notifications list table template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="alert alert-info" role="alert">
  {t(#This page allows you to adjust the types of email notifications your store sends to users#)}
</div>

<widget class="XLite\View\Form\ItemsList\Notification\Table" name="list" />
  <widget class="XLite\View\ItemsList\Model\Notification" />
<widget name="list" end />