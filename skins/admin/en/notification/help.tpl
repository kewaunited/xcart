{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Notification help
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="notification-help">
  <span>{t(#Notification headers and signatures can be set using variables. A list of supported variables and their respective values is provided in the table below#)}:</span>
  <table>
    <tr FOREACH="getVariables(),variablePlaceholder,variableValue">
      <td class="variable-placeholder">{variablePlaceholder}</td>
      <td class="variable-value">{variableValue}</td>
    </tr>
  </table>
</div>
