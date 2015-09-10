{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="cart.panel.totals", weight="1000")
*}
{if:isPayWithAmazonActive()}
<li class="button">
  <div id="payWithAmazonDiv_cart_btn">
	  <img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
  </div>
</li>
{end:}
