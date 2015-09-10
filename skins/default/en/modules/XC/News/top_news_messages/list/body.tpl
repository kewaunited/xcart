{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * News messages main template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="newsMessages-list">

  <ul class="list" IF="getPageData()">
    <li FOREACH="getPageData(),model" class="newsMessages-cell">
      <list name="row" type="inherited" model="{model}" />
    </li>
  </ul>
</div>
