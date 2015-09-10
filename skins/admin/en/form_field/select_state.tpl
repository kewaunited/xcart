{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Select state
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @TODO move it to the common selector widget
 *}

<select id="{getFieldId()}" name="{getName()}"{getAttributesCode():h} data-value="{getValue()}">
    {if:getParam(#country#)}
        <noscript>
    {end:}
    {foreach:getOptions(),index,state}
        {if:isGroup(state)}
            <optgroup {getOptionGroupAttributesCode(index,state):h} data-id='{index}'>
                {foreach:state.options,state2}
                    <option value="{state2.getStateId():r}" selected="{state2.getStateId()=getValue()}">{state2.getState():h}</option>
                {end:}
            </optgroup>
        {else:}
            <option value="{state.getStateId():r}" selected="{state.getStateId()=getValue()}">{state.getState():h}</option>
        {end:}
    {end:}
    {if:getParam(#country#)}
        </noscript>
    {end:}
</select>
