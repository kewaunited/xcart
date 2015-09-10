{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : title box : note
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.title.box", weight="100")
 *}

<div class="note">
  <widget class="XLite\View\Form\Order\Note" name="note" />
    {orderForm.displayComplexField(#staffNote#)}
  <widget name="note" end />
</div>
