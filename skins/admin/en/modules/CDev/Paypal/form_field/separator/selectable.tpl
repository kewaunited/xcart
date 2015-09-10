{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Coosable separator
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<label>
  <widget
        class="\XLite\View\FormField\Input\Radio"
        fieldOnly="true"
        isChecked="{getParam(#selected#)}"
        fieldId="{getParam(#fieldName#)}"
        fieldName="{getParam(#groupName#)}"
        value="{getParam(#value#)}" />
  <div class="table-value separator-selectable"><h3>{t(getLabel())}</h3></div>
</label>
