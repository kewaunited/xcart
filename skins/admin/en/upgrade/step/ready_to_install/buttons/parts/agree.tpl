{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkbox
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.ready_to_install.buttons.sections.right", weight="100")
 *}

<div IF="isNextStepAvailable()" class="alert alert-warning agree">
  <input type="checkbox" id="agree" name="agree" />
  <label for="agree">{t(#I confirm that I have created backups of my store's files and database before upgrading the store#):h}</label>
</div>
