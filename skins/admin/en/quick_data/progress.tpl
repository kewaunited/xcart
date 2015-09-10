{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Calculate quick data progress section
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="dialog-block quick-data-box quick-data-progress">

  <div class="header clearfix">
    <h2>{t(#Calculating quick data...#)}</h2>
  </div>

  <div class="content">
    <widget class="XLite\View\Form\QuickData" name="quickdataform" formAction="quickDataCancel" />
    <div class="subcontent">
      <widget class="XLite\View\EventTaskProgress" event="{getEventName()}" />
      <widget class="XLite\View\Button\Submit" label="{t(#Cancel#)}" />
      <div class="time">{t(#About X remaining#,_ARRAY_(#time#^getTimeLabel()))}</div>
    </div>
    <div class="help">
      <i class="icon-info-sign"></i>
      <p>
        {if:isBlocking()}
        {else:}
        {t(#The process of quick data calculation may take a while to complete. Please do not close this page until the process is fully completed.#)}
        {end:}
      </p>
    </div>
    <widget name="quickdataform" />
  </div>

</div>
