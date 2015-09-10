{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:isPopoverDisplayed()}

  <div class="edit-options-dialog" style="display: none;">
    <a href="#" class="close" title="{t(#Close#)}">×</a>
    <widget class="\XLite\View\Product\AttributeValues" orderItem="{entity}" idx="{getIdx()}" />
  </div>
  <div class="edit-options-link">
    <a href="javascript: void(0);" class="open-popover" data-placement="bottom">{t(#Options#)}</a>
  </div>

{else:}

  <div class="edit-options-link">
    <a href="javascript: void(0);" class="open-popup" data-popup-url="{getOptionsPopupURL(_ARRAY_(#productId#^getProductId(),#idx#^getIdx()))}">{t(#Options#)}</a>
  </div>

  <fieldset class="attribute-values-storage">
    <input FOREACH="entity.getAttributeValues(),av" type="hidden" name="{getAttributeInputName(entity,av)}" value="{getAttributeValue(av)}" />
  </fieldset>

{end:}
