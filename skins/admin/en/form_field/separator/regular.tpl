{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Separator field
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<h2 data-name="{getName()}">
  {t(getLabel())}
  <widget IF="hasHelp()" class="\XLite\View\Tooltip" text="{t(getParam(#help#))}" helpWidget="{getParam(#helpWidget#)}" isImageTag=true className="help-icon" />
</h2>
