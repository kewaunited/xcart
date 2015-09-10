{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment transactions page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<widget class="XLite\View\ModuleBanner" moduleName="QSL\AbandonedCartReminder" />

<widget IF="isSearchVisible()" template="common/dialog.tpl" body="payment_transactions/search.tpl" />
<widget template="common/dialog.tpl" body="payment_transactions/list.tpl" />