{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list : right action
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="payment.methods.list.row", weight=300)
 *}
<div IF="hasRightActions(method)" class="action right-action">

  {if:canRemoveMethod(method)}
    <img src="images/spacer.gif" class="separator" alt="" />
    <div IF="canRemoveMethod(method)" class="remove"><a href="{buildURL(#payment_settings#,#remove#,_ARRAY_(#id#^method.getMethodId()))}" class="fa fa-trash-o" title="{t(#Remove#)}"></a></div>
    <img src="images/spacer.gif" class="separator" alt="" />
  {end:}

  {if:method.getWarningNote()}
    <div class="warning"><a href="{method.getConfigurationURL()}" class="fa fa-exclamation-circle" title="{method.getWarningNote()}"></a></div>
  {elseif:!method.isCurrencyApplicable()}
    <div class="warning"><a href="{buildURL(#currency#)}" class="fa fa-exclamation-circle" title="{t(#This method does not support the current store currency and is not available for customers#)}" /></a></div>
  {elseif:method.isTestMode()}
    <div class="test-mode"><a href="{method.getConfigurationURL()}" title="{t(#This method is in test mode#)}"><img src="images/spacer.gif" alt="" /></a></div>
  {elseif:method.isConfigurable()}
    <div class="warning"></div>
    <widget class="XLite\View\Button\Link" label="{t(#Configure#)}" location="{method.getConfigurationURL()}" style="configure"/>
  {else:}
    <div class="warning"></div>
  {end:}

  <widget IF="isSeparateConfigureButtonVisible(method)" class="XLite\View\Button\Link" label="{t(#Configure#)}" location="{method.getConfigurationURL()}" style="configure"/>

</div>

<list name="{getAfterListName(method)}" type="nested" />
