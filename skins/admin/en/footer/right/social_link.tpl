{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Link to Facebook
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="admin.main.page.footer.right", weight="300")
 *}

<div IF="!auth.isAdmin()" class="social-links">
  <span>{t(#Find us on#)}</span>
  <a href="http://www.facebook.com/xcart/" class="facebook" target="_blank" title="{t(#Facebook#)}"><i class="fa fa-facebook-square"></i></a>
  <a href="https://twitter.com/x_cart" class="twitter" target="_blank" title="{t(#Twitter#)}"><i class="fa fa-twitter-square"></i></a>
</div>
