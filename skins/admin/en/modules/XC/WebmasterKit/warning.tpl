{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Module settings page warning
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="crud.modulesettings.header", zone="admin", weight="10")
 *}

<div IF="target=#module#&module.getActualName()=#XC\WebmasterKit#" class="alert alert-warning">
  {t(#Webmaster Kit module is recommended for use by advanced users only. It must not be used on production servers as it may significantly reduce the website performance.#)}
</div>
