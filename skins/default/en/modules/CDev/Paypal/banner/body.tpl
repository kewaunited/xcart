{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Paypal Credit banner
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="paypal-credit {getCSSClasses()}">
  <script type="text/javascript" data-pp-pubid="{getPublisherId()}" data-pp-placementtype="{getPlacementType()}">
    //<![CDATA[
    (function (d, t) {
      "use strict";
      var s = d.getElementsByTagName(t)[0], n = d.createElement(t);
      n.src = "//paypal.adtag.where.com/merchant.js";
      s.parentNode.insertBefore(n, s);
    }(document, "script"));
    //]]>
  </script>
</div>
