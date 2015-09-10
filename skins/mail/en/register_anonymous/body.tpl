{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Register anonymous email body (to customer)
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
  {t(#Your account email is X.#,_ARRAY_(#email#^profile.login))}<br/>
  {t(#Your account password is X.#,_ARRAY_(#password#^password))}
</p>
