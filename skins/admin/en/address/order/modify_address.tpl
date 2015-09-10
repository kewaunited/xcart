{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerAttributes()):h}>

  <widget class="XLite\View\Form\Order\Address" name="modifyAddress" />
    <list name="address.order.main" />
  <widget name="modifyAddress" end />

</div>
