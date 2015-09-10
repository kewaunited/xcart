{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules main section list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.module.manage.columns.module-main-section", weight="1000")
 *}

<script type="text/javascript">
  moduleNames['{module.getModuleID()}'] = '{getFormattedModuleName(module)}';
  moduleStatuses['{module.getModuleID()}'] = '{if:module.getEnabled()}1{else:}0{end:}';
  depends['{module.getModuleID()}'] = [];
  {foreach:module.getDependencyModules(),k,m}
    depends['{module.getModuleID()}']['{k}'] = '{m.getModuleID()}';
    if (!moduleNames['{m.getModuleID()}']) {
      moduleNames['{m.getModuleID()}'] = '{getFormattedModuleName(m)}';
    }
  {end:}

  dependents['{module.getModuleID()}'] = [];
  {foreach:module.getDependentModules(),k,m}
    dependents['{module.getModuleId()}'].push('{m.getModuleID()}');
  {end:}
</script>
