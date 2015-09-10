{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="checkout.shipping.selected.sub.payment", weight="2000")
*}
{if:isPayWithAmazonActive()}
<div style="padding-left: 57px;">
  <div id="payWithAmazonDiv_co_btn">
	  <img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
  </div>
</div>
{end:}
