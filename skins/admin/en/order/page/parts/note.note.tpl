{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order notes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.note", weight="100")
 *}

<div class="admin-note">
  <widget class="\XLite\View\FormField\Textarea\Simple" label="Order note" fieldName="adminNotes" value="{order.getAdminNotes()}" />
</div>
