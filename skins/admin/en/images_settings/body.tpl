{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Images settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:isImageResizeNotFinished()}

<widget class="\XLite\View\ImageResize\Progress" />

{else:}

<widget class="\XLite\View\Form\ImagesSettings" name="images_settings" />

<list name="images_settings" />

<widget class="\XLite\View\StickyPanel\ImagesSettings" />

<widget name="images_settings" end />

{end:}
