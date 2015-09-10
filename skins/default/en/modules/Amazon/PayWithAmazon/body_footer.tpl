{* vim: set ts=2 sw=2 sts=2 et: *}
{**
 * @ListChild (list="body", weight="999000")
*}
{if:isPayWithAmazonActive()}
  <script type="text/javascript" src="{getAmazonJSURL()}"></script>
{end:}
