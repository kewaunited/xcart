{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Date cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<widget template="items_list/model/table/field.tpl" />
<span class="date">{formatDate(entity.getDate())}.</span>
<span class="time">{formatDayTime(entity.getDate())}</span>
