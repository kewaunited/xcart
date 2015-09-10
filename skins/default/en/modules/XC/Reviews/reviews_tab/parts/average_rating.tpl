{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Average product rating widget in reviews tab
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="product-average-rating clearfix" IF="{isVisibleAverageRatingOnPage()}">
  <input type="hidden" name="target_widget" value="\XLite\Module\XC\Reviews\View\Customer\ReviewsTab\AverageRating" />
  <div class="comment">{t(#Average rating#)}:</div>
  <list name="reviews.product.rating" place="tab" />
  <div class="comment">
    {t(#Score: X. Votes: Y#,_ARRAY_(#score#^getAverageRating(),#votes#^getVotesCount()))}
  </div>
  {if:isVisibleAverageRating()}
  <input type="button" value="Average rating" name="showRating" id="btnAverageRating" class="button-average-rating" />

  <div class="product-average-rating-container">
    <div class="product-average-rating">
      <list name="reviews.rating.details" />
    </div>
  </div>
  {end:}

</div>
