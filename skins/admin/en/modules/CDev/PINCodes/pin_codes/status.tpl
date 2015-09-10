{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pin codes status box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:entity.isSold}

  <div class="pin-sold">{t(#Sold#)}</div>
  {if:entity.orderItem}
    ( <a target="_blank" href="{buildURL(#order#,##,_ARRAY_(#order_number#^entity.orderItem.order.orderNumber))}">#{entity.orderItem.order.orderNumber}</a> )
  {else:}
    ( {t(#Order deleted#)} )
  {end:}

{else:}

  {if:entity.isBlocked}

    <div class="pin-blocked">{t(#Blocked#)}</div>
    {if:entity.orderItem}
      ( <a target="_blank" href="{buildURL(#order#,##,_ARRAY_(#order_number#^entity.orderItem.order.orderNumber))}">#{entity.orderItem.order.orderNumber}</a> )
    {else:}
      ( {t(#Order deleted#)} )
    {end:}

  {end:}

{end:}

