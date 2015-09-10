{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Egoods email body (to customer)
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
  <ul>
    <li FOREACH="order.getDownloadAttachments(),attachment"><a href="{attachment.getURL()}">{attachment.attachment.getPublicTitle()}</a></li>
  </ul>
</p>
