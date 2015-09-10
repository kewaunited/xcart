{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Package detail
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="package-list">
  <li FOREACH="getAuctionIncPackage(),index,package" class="package-list-item">
    <widget class="XLite\Module\XC\AuctionInc\View\Order\Package" package="{package}" index="{index}" order="{order}" />
  </li>
</ul>