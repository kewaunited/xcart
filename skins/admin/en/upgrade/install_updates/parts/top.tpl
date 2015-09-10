{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top message for the advanced mode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.install_updates.sections", weight="100")
 *}

<div IF="isAdvancedMode()" class="upgrade-warning">{t(#In advanced mode you can choose specific modules for upgrade.#)}</div>

<div IF="isAdvancedMode()" class="alert alert-warning upgrade-warning">{t(#Please take your attention that it is not guaranteed the correct site operation after upgrade if you select to not upgrade all.#)}</div>
