{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Inline container
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerAttributes()):h}>
  {if:hasSeparateView()}
    <div {printTagAttributes(getViewContainerAttributes()):h}><widget template="{getViewTemplate()}" /></div>
  {end:}
  {if:isEditable()}
    <div {printTagAttributes(getFieldContainerAttributes()):h}><widget template="{getFieldTemplate()}" /></div>
  {end:}
</div>
