{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Rating value in product info
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="reviews.product.rating.average", weight="100")
 *}
<div class="product-average-rating" IF="{isVisibleAverageRatingOnPage()}">
  <input type="hidden" name="target_widget" value="\XLite\Module\XC\Reviews\View\Customer\ProductInfo\Details\AverageRating" />
  <input type="hidden" name="widgetMode" value="{getWidgetMode()}" />
  <list name="reviews.product.rating" product="{getRatedProduct()}" />
  <div IF="isVisibleReviewsCount()&getReviewsCount()>0" class="reviews-count no-reviews">
    <a href="{getRatedProductURL()}" class="link-to-tab">
      {t(#Reviews: X#,_ARRAY_(#count#^getReviewsCount()))}
    </a>
  </div>
  <div IF="isVisibleReviewsCount()&getReviewsCount()=0" class="reviews-count">
    {t(#No reviews.#)}
    <a href="{getRatedProductURL()}" class="link-to-tab">
      <widget IF="{isAllowedAddReview()}" class="\XLite\Module\XC\Reviews\View\Button\Customer\AddReviewLink" label="{t(#Be the first and leave a feedback.#)}" product="{product}" />      
    </a>
  </div>
</div>
