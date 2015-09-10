{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders search summary
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.search.base", weight="10")
 *}
<div IF="getTotalCount()!=0" class="order-search-title head-h2">{t(#X orders#,_ARRAY_(#count#^getTotalCount())):h}</div>
<div IF="getTotalCount()=0" class="order-search-title head-h2">{t(#No orders#)}</div>
