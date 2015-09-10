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

namespace XLite\View\Base;

/**
 * Lazy load container
 */
abstract class ALazyLoad extends \XLite\View\AView
{
    const PARAM_LAZY_CLASS        = 'lazyClass';
    const PARAM_LAZY_CLASS_PARAMS = 'lazyClassParams';

    /**
     * Lazy widget
     *
     * @var \XLite\View\AView
     */
    protected $lazyWidget = null;

    /**
     * Register CSS§ files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $lazyWidget = $this->getLazyWidget();

        return array_merge($list, $lazyWidget->getCSSFiles());
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'lazy_load/controller.js';
        $lazyWidget = $this->getLazyWidget();

        return array_merge($list, $lazyWidget->getJSFiles());
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'lazy_load/body.tpl';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_LAZY_CLASS
                => new \XLite\Model\WidgetParam\String('Lazy class', $this->getDefaultLazyClass()),
            self::PARAM_LAZY_CLASS_PARAMS
                => new \XLite\Model\WidgetParam\Collection('Lazy class params', $this->getDefaultLazyClassParams()),
        );
    }

    /**
     * Returns default lazy class
     *
     * @return string
     */
    protected function getDefaultLazyClass()
    {
        return '';
    }

    /**
     * Returns default lazy class params
     *
     * @return array
     */
    protected function getDefaultLazyClassParams()
    {
        return array();
    }

    /**
     * Returns lazy class
     *
     * @return string
     */
    protected function getLazyClass()
    {
        return $this->getParam(static::PARAM_LAZY_CLASS);
    }

    /**
     * Returns lazy class params
     *
     * @return string
     */
    protected function getLazyClassParams()
    {
        return $this->getParam(static::PARAM_LAZY_CLASS_PARAMS);
    }

    /**
     * Returns lazy widget
     *
     * @return \XLite\View\AView
     */
    protected function getLazyWidget()
    {
        if (!isset($this->lazyWidget)) {
            $this->lazyWidget = $this->getChildWidget($this->getLazyClass(), $this->getLazyClassParams());
        }

        return $this->lazyWidget;
    }

    /**
     * Check lazy content
     * todo: check for request type (true for ajax)
     *
     * @return string
     */
    protected function hasLazyContent()
    {
        return \XLite\Core\Request::getInstance()->isAJAX()
            ? true
            : $this->getLazyWidget()->hasCachedContent();
    }

    /**
     * Returns lazy content
     *
     * @return string
     */
    protected function getLazyContent()
    {
        return $this->hasLazyContent()
            ? $this->getLazyWidget()->getContent()
            : '';
    }

    /**
     * Returns style classes
     *
     * @return array
     */
    protected function getStyleClasses()
    {
        $styleClasses = array();
        $styleClasses[] = 'lazy-load';

        if (!$this->hasLazyContent()) {
            $styleClasses[] = 'active';
        }

        return $styleClasses;
    }

    /**
     * Returns attributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        $attributes = array();
        $attributes['class'] = implode(' ', $this->getStyleClasses());
        $attributes['data-lazy-class'] = get_class($this);

        return $attributes;
    }
}
