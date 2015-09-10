{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list : line : header : switcher : button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="switch {style}" title="{title}">
<span class="inactive">{t(#paymentStatus.Inactive#)}</span>
  {if:url}<a href="{url}">{end:}
  <div><span class="fa fa-check"></span></div>
  {if:url}</a>{end:}
<span class="active">{t(#paymentStatus.Active#)}</span>
</div>
