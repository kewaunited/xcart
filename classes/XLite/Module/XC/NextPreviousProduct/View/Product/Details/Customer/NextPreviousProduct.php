<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */


namespace XLite\Module\XC\NextPreviousProduct\View\Product\Details\Customer;

/**
 * Next previous product widget
 *
 * @ListChild (list="product.details.page.info", weight="5")
 */
class NextPreviousProduct extends \XLite\View\AView
{
    /**
     * Icon width for dropdown box
     */
    const DROPDOWN_ICON_WIDTH = '110';
    const DROPDOWN_ICON_HEIGHT = '110';

    /**
     * Cookie data in $_COOKIE array
     *
     * @var array
     */
    protected $cookieData;

    /**
     * Items list object
     *
     * @var \XLite\View\ItemsList\Product\Customer\ACustomer
     */
    protected $itemsList;

    /**
     * Item position in search condition
     *
     * @var integer
     */
    protected $itemPosition;

    /**
     * Three items around current
     *
     * @var array
     */
    protected $nextPreviousItems;

    /**
     * Session cell name
     *
     * @var string
     */
    protected $sessionCell;

    /**
     * Add CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/NextPreviousProduct/style.css';

        return $list;
    }

    /**
     * Add JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/NextPreviousProduct/next-previous-product.js';

        return $list;
    }

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();

        $result[] = 'product';

        return $result;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/NextPreviousProduct/product/next-previous.tpl';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $condition = count($this->getNextPreviousItems()) <= 3
            && count($this->getNextPreviousItems()) > 1
            && !is_null($this->getItemsList())
            && is_array($this->getNextPreviousItems());

        return parent::isVisible() && $condition;
    }

    /**
     * Get dropdown icon width
     *
     * @return string
     */
    protected function getIconWidth()
    {
        return static::DROPDOWN_ICON_WIDTH;
    }

    /**
     * Get dropdown icon height
     *
     * @return string
     */
    protected function getIconHeight()
    {
        return static::DROPDOWN_ICON_HEIGHT;
    }

    /**
     * Get cookie key
     *
     * @return string
     */
    protected function getCookieData()
    {
        if (!isset($this->cookieData)) {
            $cookieKey = 'xc_np_product_' . \XLite\Core\Request::getInstance()->product_id;
            if (isset($_COOKIE[$cookieKey])) {
                $this->cookieData = json_decode($_COOKIE[$cookieKey], true);
            }
        }

        return $this->cookieData;
    }

    /**
     * Check if previous item available
     * 
     * @return boolean
     */
    protected function isPreviousAvailable()
    {
        $items = $this->getNextPreviousItems();

        return $items[0]->getProductId() == \XLite\Core\Request::getInstance()->product_id ? false : true;
    }

    /**
     * Check if next item available
     *
     * @return boolean
     */
    protected function isNextAvailable()
    {
        $items = $this->getNextPreviousItems();

        return $items[count($items)-1]->getProductId() == \XLite\Core\Request::getInstance()->product_id ? false : true;
    }

    /**
     * Get previous item
     *
     * @return \XLite\Model\Product
     */
    protected function getPreviousItem()
    {
        $items = $this->getNextPreviousItems();
        $previousItem = $items[0];
        if (!$this->isNextAvailable() && count($items) == 3) {
            $previousItem = $items[1];
        }

        return $previousItem;
    }

    /**
     * Get next item
     *
     * @return \XLite\Model\Product
     */
    protected function getNextItem()
    {
        $items = $this->getNextPreviousItems();
        $nextItem = $items[count($items)-1];
        if (!$this->isPreviousAvailable() && count($items) == 3) {
            $nextItem = $items[1];
        }

        return $nextItem;
    }

    /**
     * Is show next previous separator
     *
     * @return boolean
     */
    protected function isShowSeparator()
    {
        return $this->isNextAvailable() && $this->isPreviousAvailable();
    }

    /**
     * Get next item URL
     *
     * @return string
     */
    protected function getNextURL()
    {
        $nextItem = $this->getNextItem();

        $attributes = array(
            'product_id' => $nextItem->getProductId(),
        );

        if ($this->isProductHasMultipleCategories($nextItem)) {
            $attributes['category_id'] = $this->isStaticCategory()
                ? \XLite\Core\Request::getInstance()->category_id
                : $nextItem->getCategory()->getId();
        }

        return $this->buildURL('product', '', $attributes);
    }

    /**
     * Get previous item URL
     *
     * @return string
     */
    protected function getPreviousURL()
    {
        $previousItem = $this->getPreviousItem();

        $attributes = array(
            'product_id' => $previousItem->getProductId(),
        );

        if ($this->isProductHasMultipleCategories($previousItem)) {
            $attributes['category_id'] = $this->isStaticCategory()
                ? \XLite\Core\Request::getInstance()->category_id
                : $previousItem->getCategory()->getId();
        }

        return $this->buildURL('product', '', $attributes);
    }

    /**
     * Return true if specified product assigned to multiple categories
     * (when cleanURL is enabled, URL for products should be built with category path)
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return boolean
     */
    protected function isProductHasMultipleCategories($product)
    {
        $result = LC_USE_CLEAN_URLS
            && !(bool) \Includes\Utils\ConfigParser::getOptions(array('clean_urls', 'use_canonical_urls_only'));

        if (!$result) {
            $categories = $product->getCategories();
            $result = 1 < count($categories);
        }

        return $result;
    }

    /**
     * Returns true if need set same category id
     * in next and previous URLs
     *
     * @return boolean
     */
    protected function isStaticCategory()
    {
        return $this->getItemsList() instanceof \XLite\View\ItemsList\Product\Customer\Category\ACategory
            || $this->getItemsList() instanceof \XLite\Module\CDev\Sale\View\SaleBlock;
    }

    /**
     * json string for data attribute
     *
     * @return string
     */
    protected function getDataStringPrevious()
    {
        $data = array(
            'class'        => get_called_class(),
            'realPosition' => $this->getItemPosition() - 1,
            'sessionCell'  => $this->getSessionCellName(),
        );

        return json_encode($data);
    }

    /**
     * json string for data attribute
     *
     * @return string
     */
    protected function getDataStringNext()
    {
        $data = array(
            'class'        => get_called_class(),
            'realPosition' => $this->getItemPosition() + 1,
            'sessionCell'  => $this->getSessionCellName(),
        );

        return json_encode($data);
    }

    /**
     * Get session cell name
     *
     * @return string
     */
    protected function getSessionCellName()
    {
        if (!isset($this->sessionCell)) {

            $cookieData = $this->getCookieData();
            if (!isset($cookieData['sessionCell'])) {
                $itemsList = $this->getNativeItemsList();
                if (!is_null($itemsList)) {
                    $this->sessionCell = hash(
                        'md4',
                        $cookieData['class']
                        . print_r($itemsList->getSearchConditionWrapper(), true)
                    );

                    \XLite\Core\Session::getInstance()->{$this->sessionCell} = array(
                        'cnd'        => $itemsList->getSearchConditionWrapper(),
                        'items_list' => get_class($itemsList),
                        'params'     => $this->getSessionParams(),
                    );
                }
            } else {
                $this->sessionCell = $cookieData['sessionCell'];
            }
        }

        return $this->sessionCell;
    }

    /**
     * Get params for session cell
     *
     * @return array
     */
    protected function getSessionParams()
    {
        $listParams = \XLite\Core\Session::getInstance()->{$this->getNativeSessionKey()};

        return $listParams;
    }

    /**
     * Get session key that defined for every widgets
     *
     * @return string
     */
    protected function getNativeSessionKey()
    {
        $cookieData = $this->getCookieData();
        $itemsListClass = $cookieData['class'];
        $sessionKey = str_replace('\\', '', $itemsListClass);
        if (
            $this->getItemsList() instanceof \XLite\Module\XC\ProductFilter\View\ItemsList\Product\Customer\Category\CategoryFilter
            || $this->getItemsList() instanceof \XLite\View\ItemsList\Product\Customer\Category\Main
        ) {
            if (!empty($cookieData['parameters']) && !empty($cookieData['parameters']['category_id'])) {
                $sessionKey .= $cookieData['parameters']['category_id'];
            }
        }

        return $sessionKey;
    }

    /**
     * Get items list
     *
     * @return \XLite\View\ItemsList\Product\Customer\ACustomer
     */
    protected function getItemsList()
    {
        if (!isset($this->itemsList)) {
            $sessionListData = \XLite\Core\Session::getInstance()->{$this->getSessionCellName()};
            $params = $sessionListData['params']
                ? $sessionListData['params']
                : array();
            $listClass = $sessionListData['items_list'];

            if (class_exists($listClass)) {
                if ($params && !empty($params['category_id'])) {
                    \XLite\Core\Request::getInstance()->category_id = $params['category_id'];
                }

                $this->itemsList = new $listClass($params);
            }
        }

        return $this->itemsList;
    }

    /**
     * Get items list with params from their session cell
     *
     * @return \XLite\View\ItemsList\Product\Customer\ACustomer
     */
    protected function getNativeItemsList()
    {
        $itemsList = null;

        $cookieData = $this->getCookieData();
        if (isset($cookieData['class'])) {
            $itemsListClass = $cookieData['class'];
            $sessionName = str_replace('\\', '', $itemsListClass);
            $listParams = \XLite\Core\Session::getInstance()->$sessionName ?: array();

            if (!empty($cookieData['parameters'])) {
                foreach ($cookieData['parameters'] as $name => $value) {
                    if (!\XLite\Core\Request::getInstance()->$name) {
                        \XLite\Core\Request::getInstance()->$name = $value;
                    }
                }
            }

            $itemsList = new $itemsListClass($listParams);

        } else {
            $itemsListClass = 'XLite\View\ItemsList\Product\Customer\Category\Main';
            $listParams = array();

            $request = \XLite\Core\Request::getInstance();
            if (!isset($request->category_id)) {
                $categoryId = \XLite\Core\Database::getRepo('\XLite\Model\Product')->find($request->product_id)->getCategoryId();
                $request->{\XLite\View\ItemsList\Product\Customer\Category\ACategory::PARAM_CATEGORY_ID} = $categoryId;
            }

            $itemsList = new $itemsListClass($listParams);
        }

        return $itemsList;
    }

    /**
     * Get three items around current
     *
     * @return array
     */
    protected function getNextPreviousItems()
    {
        if (!isset($this->nextPreviousItems)) {
            $itemsList = $this->getItemsList();

            if (!is_null($itemsList)) {
                $sessionCell = \XLite\Core\Session::getInstance()->{$this->getSessionCellName()};
                $cnd = $sessionCell['cnd'];
                $position = $this->getItemPosition();
                $this->nextPreviousItems = $itemsList->getNextPreviousItems($cnd, $position);
            }
        }

        return $this->nextPreviousItems;
    }

    /**
     * Get item position in search condition
     *
     * @return integer
     */
    protected function getItemPosition()
    {
        if (!isset($this->itemPosition)) {
            $cookieData = $this->getCookieData();

            if (isset($cookieData['realPosition'])) {
                $this->itemPosition = $cookieData['realPosition'];

            } elseif (isset($cookieData['pageId']) && isset($cookieData['position'])) {
                $itemsList = $this->getItemsList();

                $pageId = $cookieData['pageId'];
                $position = $cookieData['position'];

                if (!is_null($itemsList && !is_null($pageId) && !is_null($position))) {
                    $this->itemPosition = ($pageId - 1) * $itemsList->getPagerWrapper()->getItemsPerPage() + $position;
                }

            } else {
                $sessionCell = \XLite\Core\Session::getInstance()->{$this->getSessionCellName()};

                if (isset($sessionCell['cnd'])) {
                    $productId = \XLite\Core\Request::getInstance()->product_id;
                    $cnd = $sessionCell['cnd'];
                    if ($this->getItemsList() instanceof \XLite\View\ItemsList\Product\Customer\Category\Main) {
                        $categoryId = \XLite\Core\Database::getRepo('\XLite\Model\Product')->find($productId)->getCategoryId();

                        $cnd->{\XLite\Model\Repo\Product::P_CATEGORY_ID} = $categoryId;
                    }
                    $ids = \XLite\Core\Database::getRepo('\XLite\Model\Product')->searchOnlyIds($cnd);

                    for ($i = 0; $i < count($ids); $i++) {
                        if ($ids[$i]['product_id'] == $productId) {
                            $this->itemPosition = $i;
                            break;
                        }
                    }
                }
            }
        }

        return $this->itemPosition;
    }
}
