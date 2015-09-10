{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * News message page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="newsMessage.details", weight="400")
 *}

<div class="archive-link">
  <a IF="getPreviousURL(newsMessage)" href="{getPreviousURL(newsMessage)}">{t(#Previous news#)}</a>
  <a IF="getNextURL(newsMessage)" href="{getNextURL(newsMessage)}">{t(#Next news#)}</a>
</div>
