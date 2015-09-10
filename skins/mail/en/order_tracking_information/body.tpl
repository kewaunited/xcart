{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order tracking information email body (to customer)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<p>
  {getNotificationText():h}
</p>
<p>
  <strong>{t(#Carrier#)}:</strong> {order.getShippingMethodName():h}
</p>
<p>
  <list name="tracking.info" order="{order}" trackingNumbers="{trackingNumbers}" />
  <br />
  <widget class="\XLite\View\Invoice" order="{order}" />
</p>