{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Subtotal field in view mode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{foreach:getFields(),f}
  <span class="text-grey">{t(#from wholesale#)}</span>
  <span class="value">{getViewValue(f):h}</span>
{end:}
