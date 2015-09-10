{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Import failed section : errors 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="import.failed.content", weight="100")
 *}

<h3>{getTitle()}</h3>
<ul FOREACH="getFiles(),file" class="errors">
  <li class="title">
    <i class="icon-file-alt"></i> 
    {file.file}
    <span IF="file.countW" class="count-w">{file.countW}</span>
    <span IF="file.countE" class="count-e">{file.countE}</span>
  </li>
  <li FOREACH="getErrorsGroups(file.file),errorGroup" class="clearfix type-{errorGroup.type}">
    <div class="message">
      <div class="message-text">{getGroupErrorMessage(errorGroup)}</div>
      <hr>
      <div class="rows">{getGroupErrorRows(errorGroup)}</div>
    </div>
    <div class="text">{getErrorText(errorGroup)}</div>
  </li>
</ul>
<div IF="hasErrors()" class="much-errors">{t(#Critical errors have been detected in the files you are trying to import. Please correct the errors and try again.#)}</div>
<div IF="isBroken()" class="much-errors">{t(#Import has been cancelled.#)}</div>
