{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Review 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="entity.review" class="review-text">
  <widget
    class="\XLite\View\Tooltip"
    id="review-{entity.getId()}-full-text"
    text="{getReviewFullContent(entity):h}"
    caption="{getReviewShortContent(entity)}"
    isImageTag="false"
     />
</div>
