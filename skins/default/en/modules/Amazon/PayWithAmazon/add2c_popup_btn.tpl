{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="add2cart_popup.item", weight="1000")
*}
{if:isPayWithAmazonActive()}
<div id="payWithAmazonDiv_add2c_popup_btn" style="padding:8px 0 0 200px;">
	<img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
</div>
{end:}
