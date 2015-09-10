{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order advanced changed email body (to customer)
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
  <widget class="\XLite\View\Invoice" order="{order}" />

  <list IF="!order.trackingNumbers.isEmpty()" name="tracking.info" order="{order}" trackingNumbers="{order.trackingNumbers}" />
</p>
