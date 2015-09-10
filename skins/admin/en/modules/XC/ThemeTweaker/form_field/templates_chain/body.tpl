{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Templates chain
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div{getAttributesCode():h}>
  <div FOREACH="getChain(),_link,_body" class="chain-link">
    <a href="javascript: void(0);" data-content="{_body}">{_link}</a>
  </div>
</div>
