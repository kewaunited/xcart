/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * News messages controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function NewsMessagesItemsListController(base)
{
  NewsMessagesItemsListController.superclass.constructor.apply(this, arguments);
}

extend(NewsMessagesItemsListController, ListsController);

NewsMessagesItemsListController.prototype.name = 'NewsMessagesItemsListController';

NewsMessagesItemsListController.prototype.findPattern += '.news-messages';

NewsMessagesItemsListController.prototype.getListView = function()
{
  return new NewsMessagesItemsListView(this.base);
}

function NewsMessagesItemsListView(base)
{
  NewsMessagesItemsListView.superclass.constructor.apply(this, arguments);
}

extend(NewsMessagesItemsListView, ListView);

NewsMessagesItemsListView.prototype.postprocess = function(isSuccess, initial)
{
  NewsMessagesItemsListView.superclass.postprocess.apply(this, arguments);

  if (isSuccess) {
    // Some routines
  }
}

core.autoload(NewsMessagesItemsListController);
