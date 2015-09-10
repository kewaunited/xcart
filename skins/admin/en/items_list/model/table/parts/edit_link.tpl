{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Edit link 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="entity-edit-link" {getEditLinkAttributes(entity,column)}>
  <a href="{buildEntityURL(entity,column)}" class="regular-button" role="button">{getEditLinkLabel(entity)}</a>
</div>
