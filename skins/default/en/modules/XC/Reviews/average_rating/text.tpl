{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Rating value in text
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="reviews.page.rating", weight="200")
 * @ListChild (list="reviews.tooltip.rating", weight="200")
 *}
<div class="text">
  <div IF="getAverageRating()>0">{t(#Score: X. Votes: Y#,_ARRAY_(#score#^getAverageRating(),#votes#^getVotesCount()))}</div>
  <div IF="getAverageRating()=0">{t(#Not rated yet#)}</div>
</div>
