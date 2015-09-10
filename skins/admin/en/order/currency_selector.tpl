{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Currency selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Form\Order\CurrencySelector" name="selector" />

  <widget
          class="\XLite\View\FormField\Select\Order\Currency"
          fieldOnly="true"
          fieldName="currency"
          value="{getCurrentCurrencyId()}" />


  <list name="statistic.currency_selector.after" />

<widget name="selector" end />
