{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * News messages :: name cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.newsMessages.customer.center.row", weight="200")
 *}

<div class="news-message-link"><a href="{buildURL(#news_message#,##,_ARRAY_(#id#^model.id))}">{model.name}</a></div>
