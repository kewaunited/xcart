{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="minicart.horizontal.buttons", weight="1000")
*}
{if:isPayWithAmazonActive()}
<div id="payWithAmazonDiv_mini_cart_btn" style="padding-top:8px;">
	<img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
</div>
{end:}
