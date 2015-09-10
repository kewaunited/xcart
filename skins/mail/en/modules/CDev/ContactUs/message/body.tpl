{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Contact us email body (to admin)
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
  <b>{t(#Name#)}:</b> {data.name}<br />
  <b>{t(#E-mail#)}:</b> {data.email}<br />
  <b>{t(#Subject#)}:</b> {data.subject}<br />
</p>
<p>
  {data.message:nl2br}
</p>