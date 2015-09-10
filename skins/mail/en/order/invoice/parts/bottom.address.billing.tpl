{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice billing address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.address.billing", weight="10")
 *}
<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">{t(#Billing address#)}</strong>
<ul style="padding-top: 12px;list-style: none;margin: 0;padding-left: 0;">
  {foreach:getAddressSectionData(baddress),idx,field}
  <widget IF="{getAddressFiledTemplate(#b#,idx,field)}" template="{getAddressFiledTemplate(#b#,idx,field)}" field="{field}" />
  {end:}
</ul>
<p style="line-height: 18px;padding-top: 0;margin: 0;font-size: 14px;margin-left:-15px;padding-left:15px;">
  <span>{t(#E-mail#)}</span>:
  <a style="font-size: 14px;color: #000;" href="mailto:{order.profile.login}">{order.profile.login}</a>
</p>
