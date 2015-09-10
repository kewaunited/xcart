{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods appearance list: Payment method name cell template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="plain-value">
  <span class="status fa fa-check" title="{getMethodStatusTitle(entity)}"></span>
  <span class="value">{entity.name:h}</span>
  <img IF="column.noWrap" src="images/spacer.gif" class="right-fade" alt="" />
</div>
