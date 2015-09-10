{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Select region
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
 
<select id="{getFieldId()}" name="{getName()}"{getAttributesCode():h}>
    <option value="">{t(#No region#)}</option>
    <option FOREACH="getOptions(),region" value="{region.code:r}" selected="{region.code=getValue()}">{region.name:h}</option>
</select>
