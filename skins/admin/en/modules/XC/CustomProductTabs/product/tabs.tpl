{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * "Tabs" tab
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:isProductTabPage()}
  <widget class="XLite\Module\XC\CustomProductTabs\View\Model\Product\Tab" useBodyTemplate="1" />
{else:}
  <widget template="common/dialog.tpl" body="modules/XC/CustomProductTabs/product/list.tpl" />
{end:}
