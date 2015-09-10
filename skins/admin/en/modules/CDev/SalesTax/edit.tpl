{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tax edit page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="{getDialogCSSClasses()}">

  <widget name="editForm" class="\XLite\Module\CDev\SalesTax\View\Form\EditTax" />

  <table class="form" cellspacing="0">

    <tr>
      <td class="label"><label for="tax-title">{t(#Tax title#)}:</label></td>
      <td class="star">*</td>
      <td><input type="text" name="name" value="{tax.getName()}" class="field-required" /></td>
      <td class="button {if:tax.getEnabled()}enabled{else:}disabled{end:}">
          <widget class="\XLite\View\Button\SwitchState" label="{t(#Tax enabled#)}" enabled="true" action="switch" />
          <widget class="\XLite\View\Button\SwitchState" label="{t(#Tax disabled#)}" enabled="false" action="switch" />
      </td>
    </tr>

  </table>

  <div class="sales-tax-options">
    <div class="sales-tax-options-block">
      <widget class="\XLite\View\FormField\Input\Checkbox" fieldName="ignore_memberships" isChecked="{config.CDev.SalesTax.ignore_memberships}" label="{t(#Use the same tax rates for all user membership levels#)}" />
    </div>
    <div class="sales-tax-options-block">
      <widget class="\XLite\Module\CDev\SalesTax\View\FormField\AddressType" fieldName="addressType" value="{config.CDev.SalesTax.addressType}" label="{t(#Address for sales tax calculation#)}" />
    </div>
    <div class="sales-tax-options-block">
      <widget class="\XLite\Module\CDev\SalesTax\View\FormField\TaxableBase" fieldName="taxableBase" value="{config.CDev.SalesTax.taxableBase}" label="{t(#Taxable base#)}" />
    </div>
  </div>

  <div id="main-rates">
    <div class="title">{t(#General tax rates#)}</div>
    <widget class="XLite\Module\CDev\SalesTax\View\ItemsList\Model\Rate" />
  </div>

  <div IF="!isShippingRatesDisplayed()" id="items-list-switcher">
    <span>{t(#Click here to specify tax rates that will apply only to shipping charges#)}</span>
    <i class="fa fa-caret-right"></i>
  </div>

  <div id="shipping-rates"{if:!isShippingRatesDisplayed()} class="hidden"{end:}>
    <div class="title">{t(#Tax rates on shipping cost#)}</div>
    <widget class="XLite\Module\CDev\SalesTax\View\ItemsList\Model\ShippingRate" />
  </div>

  <div class="buttons">
    <widget class="\XLite\View\Button\Submit" label="{t(#Save changes#)}" style=" regular-main-button action" />
  </div>

  <widget name="editForm" end />

</div>
