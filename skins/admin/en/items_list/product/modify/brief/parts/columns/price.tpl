{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item price
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.product.modify.brief.admin.columns", weight="60")
 *}

<td><input type="text" class="price" size="10" value="{product.getPrice():r}" name="{getNamePostedData(#price#,product.getProductId())}" /></td>
