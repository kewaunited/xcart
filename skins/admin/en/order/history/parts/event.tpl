{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order history event
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.history.base.events", weight="20")
 *}
<li class="event" FOREACH="block,index,event">
  <list name="order.history.base.events.details.info" event="{event}" />
</li>
