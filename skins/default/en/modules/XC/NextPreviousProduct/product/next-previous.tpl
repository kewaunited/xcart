{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Next previous product links
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="next-previous-product">
    <div>
        <div IF="isPreviousAvailable()" class="next-previous-link">
            <span class="fa fa-arrow-left arrow"></span><a href="{getPreviousURL()}" class="previous-link">{t(#Previous product#):h}</a>
            <div style="display: none;" class="next-previous-cookie-data" data-xc-product-id="{previousItem.getProductId()}" data-xc-next-previous="{getDataStringPrevious()}"></div>
            <div class="next-previous-dropdown">
                    <p class="next-previous-image">
                        <a href="{getPreviousURL()}">
                        <widget
                            class="\XLite\View\Image"
                            image="{previousItem.getImage()}"
                            maxWidth="{getIconWidth()}"
                            maxHeight="{getIconHeight()}"
                            alt="{previousItem.name}"
                            className="photo" />
                        </a>
                    </p>
                    <h3><a href="{getPreviousURL()}">{previousItem.getName()}</a></h3>
                    <p class="next-previous-price">{formatPrice(previousItem.getDisplayPrice(),null,1)}</p>
            </div>

        </div>
        <span IF="isShowSeparator()" class="next-previous-separator">|</span>
        <div IF="isNextAvailable()" class="next-previous-link">
            <a href="{getNextURL()}">{t(#Next product#):h}</a><span class="fa fa-arrow-right arrow"></span>
            <div style="display: none;" class="next-previous-cookie-data" data-xc-product-id="{nextItem.getProductId()}" data-xc-next-previous="{getDataStringNext()}"></div>
            <div class="next-previous-dropdown">
                    <p class="next-previous-image">
                        <a href="{getNextURL()}">
                        <widget
                            class="\XLite\View\Image"
                            image="{nextItem.getImage()}"
                            maxWidth="{getIconWidth()}"
                            maxHeight="{getIconHeight()}"
                            alt="{nextItem.name}"
                            className="photo" />
                        </a>
                    </p>
                    <h3><a href="{getNextURL()}">{nextItem.getName()}</a></h3>
                    <p class="next-previous-price">{formatPrice(nextItem.getDisplayPrice(),null,1)}</p>
            </div>
        </div>
    </div>
</div>
