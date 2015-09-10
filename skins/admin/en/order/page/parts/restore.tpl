{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Restore modifier
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="restore-orig-price">
  <a href="#" class="auto" title="{t(#Recalculate this value automatically#)}"></a>
  <a href="#" class="manual" title="{t(#Save the existing value without re-calculating#)}"></a>
  <input type="hidden" name="auto[surcharges][{surcharge.code}][value]" {if:isAutoSurcharge(surcharge)}value="1"{else:}value=""{end:} />
</div>
