{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list : line : header : switcher
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="payment.methods.list.header", weight=300)
 *}

<div class="switcher">
  {if:canSwitch(method)}
    {if:method.getWarningNote()}
      {if:method.isEnabled()}
        <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="enabled" title="{t(#Enabled#)}" url="" />
      {else:}
        <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="disabled" title="{t(#This payment method cannot be enabled until you configure it#)}" url="" />
      {end:}

    {else:}

      {if:method.isEnabled()}
        <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="enabled" title="{t(#Disable#)}" url="{buildURL(#payment_settings#,#disable#,_ARRAY_(#id#^method.getMethodId()))}" />
      {else:}
        <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="disabled" title="{t(#Enable#)}" url="{buildURL(#payment_settings#,#enable#,_ARRAY_(#id#^method.getMethodId()))}" />
      {end:}

    {end:}

  {else:}

    {if:canEnable(method)}
      <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="enabled" title="{method.getForcedEnabledNote()}" url="" />
    {else:}
      <widget template="items_list/payment/methods/parts/header.switcher.button.tpl" style="disabled" title="{method.getForcedEnabledNote()}" url="" />
    {end:}

  {end:}
</div>
