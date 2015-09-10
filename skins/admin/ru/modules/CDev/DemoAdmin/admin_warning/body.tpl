{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Admin warning popup dialog
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="admin-warning-block">

  <div>Изменения, сделанные в интерфейсе администратора, не влияют на интерфейс покупателя.<br />Некоторые настройки могут быть недоступны.</div>

  <div>Если Вы хотите увидеть больше возможностей, создайте бесплатно <a href="http://my.x-cart.com/create_store" target="_blank">временную учетную запись</a> <span class="nowrap">X-Cart Cloud</span> или <a href="http://www.x-cart.ru/" target="_blank">скачайте</a> и установите <span class="nowrap">X-Cart.</span></div>

  <div class="actions">
    <widget class="\XLite\View\Button\Regular" label="Продолжить" jsCode="jQuery('.popup-window-entry').dialog('close');" style="close-popup" />
  </div>

</div>
