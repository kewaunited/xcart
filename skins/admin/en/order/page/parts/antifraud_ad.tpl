{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : antifraud line
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order", weight="1000")
 *}

<div IF="isDisplayAntiFraudAd()" class="antifraud-ad">

  {t(#This order was not checked by the AntiFraud service!#)}

  {t(#You can purchase AntiFraud Service subscription#)}

  <a href="{getAntiFraudAdLink()}" target="_blank">{t(#here#)}</a>.

</div>
