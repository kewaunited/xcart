{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * USPS settings page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="admin-title">{t(#U.S.P.S. settings#)}</div>

<br />

<form action="{buildURL()}" method="post">

  <input type="hidden" name="target" value="usps" />
  <input type="hidden" name="action" value="update" />
  <widget class="\XLite\View\FormField\Input\FormId" />

  <table cellpadding="2" cellspacing="1">

    <tr>
      <td colspan="2"><br /><b>{t(#Authentication options#)}</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#User ID#)}:</td>
      <td><input type="text" name="userid" value="{config.CDev.USPS.userid:r}" size="15" /></td>
    </tr>

    <tr class="usps-api-server-url">
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#U.S.P.S. API server URL#)}:</td>
      <td>
        <table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td>
              <input type="text" name="server_url" value="{config.CDev.USPS.server_url:r}" size="45" />
            </td>
            <td>
              <widget
                class="\XLite\View\Tooltip"
                id="usps-server-url-help"
                text="{t(#Enter here a URL provided to you  by U.S.P.S. in the notification about registering for the U. S. Postal Service's Web Tools Application Program Interfaces#)}"
                caption=""
                isImageTag="true"
                className="help-icon" />
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td colspan="2"><br /><b>{t(#Common options#)}</b></td>
    </tr>

    <tr>
      <td valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;{t(#Package dimensions (inches)#)}:</td>
      <td>
        <table cellspacing="1" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td>{t(#Length#)}</td>
              <td></td>
              <td>{t(#Width#)}</td>
              <td></td>
              <td>{t(#Height#)}</td>
            </tr>
            <tr>
              <td><input type="text" size="6" name="length" value="{config.CDev.USPS.length:r}" /></td>
              <td>&nbsp;x&nbsp;</td>
              <td><input type="text" size="6" name="width" value="{config.CDev.USPS.width:r}" /></td>
              <td>&nbsp;x&nbsp;</td>
              <td><input type="text" size="6" name="height" value="{config.CDev.USPS.height:r}" /></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Girth (inches)#)}:</td>
      <td><input type="text" name="girth" value="{config.CDev.USPS.girth:r}" size="8" /></td>
    </tr>

    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;{t(#(required for large size and container is non-rectangular or variable)#)}<br /><br /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Maximum package weight#)} ({getWeightSymbol()}):</td>
      <td><input type="text" name="max_weight" value="{config.CDev.USPS.max_weight:r}" size="10" /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Currency conversion rate#)}:</td>
      <td><input type="text" name="currency_rate" value="{config.CDev.USPS.currency_rate:r}" size="8" /></td>
    </tr>

    <tr>
      <td colspan="2">
        &nbsp;&nbsp;&nbsp;&nbsp;{t(#(specify rate X, where 1 USD = X in shop currency)#)}<br />
        &nbsp;&nbsp;&nbsp;&nbsp;{t(#The shipping cost is always returned in US Dollars. So if the store use other currency for payments you need to specify#)}<br />
        &nbsp;&nbsp;&nbsp;&nbsp;{t(#the conversion rate to convert the shipping cost returned by shipping service into the necessary currency. Otherwise leave 1.#)}
      </td>
    </tr>

    <tr>
      <td colspan="2"><br /><b>{t(#Domestic U.S.P.S.#)}</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Container#)}:</td>
      <td>
        <select name="container">
        {foreach:getContainerOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.container,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Package Size (length + girth, inches)#)}:</td>
      <td>
        <select name="package_size">
        {foreach:getPackageSizeOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.package_size,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#First-Class mail type#)}:</td>
      <td>
        <select name="first_class_mail_type">
        {foreach:getFirstClassMailTypeOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.first_class_mail_type,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Machinable#)}:</td>
      <td><input type="checkbox" name="machinable" value="Y"{if:config.CDev.USPS.machinable=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Pricing type to be used#)}:</td>
      <td>
        <select name="use_rate_type">
        {foreach:getUseRateTypeOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.use_rate_type,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr class="use-cod-price">
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Use a fixed amount Collect on Delivery fee#)}:</td>
      <td>
        <input type="checkbox" id="use-cod-price-setting" name="use_cod_price" value="Y"{if:config.CDev.USPS.use_cod_price=#Y#} checked="checked"{end:} />
        <widget
            class="\XLite\View\Tooltip"
            id="usps-use-cod-price-help"
            text="{t(#If you are planning to allow your customers to use the COD payment method for orders shipped with USPS shipping methods, you can make the calculation of shipping costs faster by setting a fixed extra fee for using the COD payment method.#)}"
            caption=""
            isImageTag="true"
            className="help-icon" />
      </td>
    </tr>

    <tr class="cod-price"{if:!config.CDev.USPS.use_cod_price=#Y#} style="display: none;"{end:}>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#COD fee ($)#)}:</td>
      <td>
        <input type="text" name="cod_price" value="{config.CDev.USPS.cod_price:r}" size="10" />
        <widget
            class="\XLite\View\Tooltip"
            id="usps-cod-price-help"
            text="{t(#If you have selected to use a fixed COD fee, specify the fee amount here.#)}"
            caption=""
            isImageTag="true"
            className="help-icon" />
      </td>
    </tr>

    <tr>
      <td colspan="2"><br /><b>{t(#International U.S.P.S.#)}</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Mail type#)}:</td>
      <td>
        <select name="mail_type">
        {foreach:getMailTypeOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.mail_type,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Container#)}:</td>
      <td>
        <select name="container_intl">
        {foreach:getContainerIntlOptions(),opkey,opval}
          <option value="{opkey}" selected="{isSelected(config.CDev.USPS.container_intl,opkey)}">{opval}</option>
        {end:}
        </select>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Get commercial base postage#)}:</td>
      <td><input type="checkbox" name="commercial" value="Y"{if:config.CDev.USPS.commercial=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Global Express Guarantee (GXG)#)}:</td>
      <td><input type="checkbox" name="gxg" value="Y"{if:config.CDev.USPS.gxg=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#GXG destination is a post office box#)}:</td>
      <td><input type="checkbox" name="gxg_pobox" value="Y"{if:config.CDev.USPS.gxg_pobox=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#GXG package contains a gift#)}:</td>
      <td><input type="checkbox" name="gxg_gift" value="Y"{if:config.CDev.USPS.gxg_gift=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td colspan="2"><br /><b>{t(#Additional options#)}</b></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Log all comunications between shopping cart and USPS server#)}:</td>
      <td><input type="checkbox" name="debug_enabled" value="Y"{if:config.CDev.USPS.debug_enabled=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;{t(#Auto enable new USPS shipping methods#)}:</td>
      <td><input type="checkbox" name="autoenable_new_methods" value="Y"{if:config.CDev.USPS.autoenable_new_methods=#Y#} checked="checked"{end:} /></td>
    </tr>

    <tr>
      <td colspan="2"><br /><widget class="\XLite\View\Button\Submit" label="Save" style="action" /></TD>
    </tr>

  </table>

</form>
