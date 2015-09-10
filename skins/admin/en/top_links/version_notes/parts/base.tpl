{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * "Core version" info
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="admin.main.page.header", weight="20")
 *}
<div IF="!auth.isLogged()" class="base-version">{t(#X-Cart shopping cart software#)}</div>
