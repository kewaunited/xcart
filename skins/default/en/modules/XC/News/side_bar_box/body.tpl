{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Disqus comments template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class='XLite\Module\XC\News\View\ItemsList\NewsMessages\TopNewsMessages' />
<li class="more_link" IF="isShowMoreLink()">
    <a class="link" href="{getMoreLinkURL()}">{getMoreLinkText()}</a>
</li>
