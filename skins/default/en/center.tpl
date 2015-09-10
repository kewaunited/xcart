{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Center column
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<list name="center.top" />

<h1 class="title" id="page-title" IF="isTitleVisible()&getTitle()">{getMainTitle()}</h1>

<widget template="center_top.tpl" />

<list name="center.bottom" />
