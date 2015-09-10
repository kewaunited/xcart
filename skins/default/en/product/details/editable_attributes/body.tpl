{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details attributes block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="hasAttributes()" class="editable-attributes {getFingerprint()}">
  <widget class="\XLite\View\Product\Details\Customer\AttributesModify" product="{product}" />
</div>
