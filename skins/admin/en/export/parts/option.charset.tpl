{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Export begin section : settings : charset setting
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="export.begin.options", weight="300")
 *}

<li IF="isCharsetEnabled()" class="charset-option">
  <widget class="XLite\View\FormField\Select\IconvCharset" fieldName="options[charset]" label="{t(#Character set#)}" value="{config.Units.export_import_charset}" />
</li>
