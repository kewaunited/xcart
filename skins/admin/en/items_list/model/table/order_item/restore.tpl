{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Total cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.orderitem.cell.price", weight="100")
 * @ListChild (list="itemsList.orderitem.dumpCell.price", weight="100")
 *}

<div class="restore-orig-price" data-orig-price="{getOriginalPrice(entity)}">
  <i class="fa fa-money" title="{t(#Current price for the selected configuration and quantity: X#,_ARRAY_(#price#^formatPrice(getOriginalPrice(entity),order.currency)))}"></i>
  <input type="hidden" name="auto[items][{entity.item_id}][price]" {if:isAutoItem(entity,#price#)}value="1"{else:}value=""{end:} />
</div>
