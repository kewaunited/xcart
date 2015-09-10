{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Left side menu info node
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<li {printTagAttributes(getNodeTagAttributes()):h}>
  {if:getHeaderURL()}
  <a href="{getHeaderURL()}">
    <div class="notification-header">
      {getIcon():h}
      <span>{getHeader()}</span>
      <div IF="getCounter()" class="counter">{getCounter()}</div>
    </div>
  </a>
  {else:}
  <div class="notification-header">
    {getIcon():h}
    <span>{getHeader()}</span>
    <div IF="getCounter()" class="counter">{getCounter()}</div>
  </div>
  {end:}

  <ul>
    <li FOREACH="getMessages(),message">
      <a href="{message.link:h}"{if:message.external} target="_blank"{end:}>
        <div class="message">
          <img src="{message.image}" class="addon-icon" alt="{message.title}" />
          <span class="title">{message.title}</span>
          <span class="description">{message.description}</span>
        </div>
      </a>
    </li>
  </ul>
</li>
