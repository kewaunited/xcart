{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods list : right action
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="payment.methods.list.row.after.ExpressCheckout", weight=100)
 *}
<div IF="method.getReferralPageURL()|getKnowledgeBasePageURL(method)" class="learn-more">
  <a IF="getKnowledgeBasePageURL(method)" href="{getKnowledgeBasePageURL(method)}" target="_blank">{t(#Learn More#)}</a>
  <span IF="method.getReferralPageURL()&getKnowledgeBasePageURL(method)">&amp;</span>

  {if:method.getReferralPageURL()}

  {if:method.isInContextSignUpAvailable()}
  <a href="{method.getReferralPageURL()}" target="PPFrame" data-paypal-button="true">{t(#Sign Up#)}</a>
  {else:}
  <a href="{method.getReferralPageURL()}" target="_blank">{t(#Sign Up#)}</a>
  {end:}

  {end:}

</div>
