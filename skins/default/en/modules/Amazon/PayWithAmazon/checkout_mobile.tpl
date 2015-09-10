{* vim: set ts=2 sw=2 sts=2 et: *}
<script type="text/javascript">
//<![CDATA[
var txt_accept_terms_err = 'Please accept terms';
var msg_being_placed     = 'being placed...';
var amazon_pa_orefid = '{getAmazonOrderRefId()}';

var amazon_pa_place_order_enabled = false;
var amazon_pa_address_selected = false;
var amazon_pa_payment_selected = false;
//]]>
</script>
{* <script type="text/javascript" src="skins/default/en/modules/Amazon/PayWithAmazon/func.js"></script> *}

<h1>{t(#Pay with Amazon#)}</h1>

<table cellspacing="0" cellpadding="0" width="100%" class="amazon-mobile-checkout-tbl">
<tr>
  <td align="center">

    {* amazon widgets *}
    <div id="addressBookWidgetDiv"></div>
    <br />
    <br />
    <div id="walletWidgetDiv"></div>
    <br />

    <div class="checkout-container">
    <div class="checkout-block">
    <div class="steps clearfix">

    <h3>{t(#Delivery methods#)}</h3>
    <div class="step shipping-step">
      <div class="substep step-shipping-methods">
        <widget class="\XLite\View\Checkout\ShippingMethodsList" />
      </div>
    </div>

    <br />
    <br />

    <h3>{t(#Order review#)}</h3>
    <div class="step review-step">
      <div class="step-box clearfix">
        {* <list name="checkout.review.selected" /> *}
      </div>
    </div>

    </div>
    </div>
    </div>

  </td>
</tr>
</table>
