{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Images sizes settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="images_settings", weight="100")
 *}

<div class="custom-images">

  <h2>{t(#Custom images#)}</h2>

  <widget class="\XLite\Module\XC\ThemeTweaker\View\Images" />

  <div class="new-image">
    {t(#New images#)}: <input type="file" name="new_images[]" multiple />
  </div>

</div>
