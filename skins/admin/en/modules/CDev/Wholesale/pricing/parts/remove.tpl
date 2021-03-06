{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Remove button for wholesale prices items list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget IF="!isRemovableEntity(entity)" template="items_list/model/table/parts/empty.tpl" />
<widget IF="isRemovableEntity(entity)" template="items_list/model/table/parts/remove.tpl" />
