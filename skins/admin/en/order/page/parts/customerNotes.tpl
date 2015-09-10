{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : customer notes box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.items.bottom", weight="200")
 *}

<div IF="isCustomerNotesVisible()" class="customer-notes">
  <h3>{t(#Customer note#)}</h3>
  <list name="order.customerNotes" />
</div>
