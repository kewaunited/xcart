{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Login error email body (to admin)
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
  ENTERED LOGIN: {login}<br />
  REMOTE_ADDR: {REMOTE_ADDR}<br />
  HTTP_X_FORWARDED_FOR: {HTTP_X_FORWARDED_FOR}<br />
  HTTP_REFERER: {HTTP_REFERER}<br />
</p>
