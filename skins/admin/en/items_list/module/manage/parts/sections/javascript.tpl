{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.module.manage.sections", weight="100")
 *}

<script type="text/javascript">
//<![CDATA[
var confirmNotes = [];
confirmNotes['uninstall'] = '{t(#Are you sure you want to uninstall this add-on?#)}';
confirmNotes['delete']    = '{t(#Are you sure you want to uninstall selected add-ons?#)}';
confirmNotes['enable']    = '{t(#Are you sure you want to enable this add-on?#)}';
confirmNotes['disable']   = '{t(#Are you sure you want to disable this add-on?#)}';
confirmNotes['enableDependent'] = '{t(#Please note that the following modules will also be enabled#)}';
confirmNotes['default']   = '{t(#Are you sure?#)}';
var dependedAlert = '{t(#The following dependent add-ons will be disabled  automatically#)}:';
var depends = [];
var dependents = [];
var moduleStatuses = [];
var uninstallModules = [];
var moduleNames = [];
//]]>
</script>
