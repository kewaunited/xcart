{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Regular button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<button {printTagAttributes(getAttributes()):h}>
{if:getParam(#icon-style#)}
  <i class="button-icon {getParam(#icon-style#)}"></i>
{end:}
  <span>{t(getButtonLabel())}</span>
</button>
