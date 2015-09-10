{*
vim: set ts=2 sw=2 sts=2 et:
@ListChild (list="tabs.items", zone="admin", weight="5")
*}
{if:isPaymentMethodsPage()}
<li class="tab">
  <a href="{getModuleSettingsURL()}">{t(#Pay with Amazon#)}</a>
</li>
{end:}
