{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:!getParam(#fieldOnly#)}
  <div class="{getLabelContainerClass()}">
    <label IF="getParam(#useColon#)" for="{getFieldId()}" title="{getFormattedLabel():h}">
      {getFormattedLabel()}:
      <widget IF="hasLabelHelp()" class="\XLite\View\Tooltip" text="{t(getParam(#labelHelp#))}" helpWidget="{getParam(#labelHelpWidget#)}" isImageTag=true className="help-icon" />
    </label>
    <label IF="!getParam(#useColon#)" for="{getFieldId()}" title="{getFormattedLabel():h}">
      {getFormattedLabel()}
      <widget IF="hasLabelHelp()" class="\XLite\View\Tooltip" text="{t(getParam(#labelHelp#))}" helpWidget="{getParam(#labelHelpWidget#)}" isImageTag=true className="help-icon" />
    </label>
  </div>
  <div IF="getParam(#required#)" class="star">*</div>
  <div IF="!getParam(#required#)" class="star">&nbsp;</div>
{end:}

<div class="{getValueContainerClass()}">
  <widget template="{getDir()}/{getFieldTemplate()}" />
    {if:getParam(#linkHref#)}
      {if:getParam(#linkImg#)}
        <img src="{getParam(#linkImg#)}" class="form-field-link-img" alt="" height="20">
      {end:}
      <a class="form-field-link {getFieldId()}-link" href="{getParam(#linkHref#)}">        
        {t(getParam(#linkText#)):h}
      </a>
    {end:}
  <widget IF="hasHelp()" class="\XLite\View\Tooltip" text="{t(getParam(#help#))}" helpWidget="{getParam(#helpWidget#)}" isImageTag=true className="help-icon" />
  <div IF="getParam(#comment#)" class="form-field-comment {getFieldId()}-comment">{t(getParam(#comment#)):h}</div>
  {if:getFormFieldJSData()}{displayCommentedData(getFormFieldJSData())}{end:}
  <script IF="getInlineJSCode()" type="text/javascript">{getInlineJSCode():h}</script>
</div>

{if:!getParam(#fieldOnly#)}
  <div class="clear"></div>
{end:}
