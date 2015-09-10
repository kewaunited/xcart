{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order address : info
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="address.order.main", weight="100")
 *}

<div class="info">
  <strong><a href="{buildURL(#profile#,##,_ARRAY_(#profile_id#^order.origProfile.profileId))}">{getName()}</a></strong>
  <span class="separator">-</span>
  <span class="email"><a href="mailto:{getEmail()}">{getEmail()}</a></span>
</div>
