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

namespace XLite\View\FormField\Inline\Popup;

/**
 * Abstract popup-based inline field
 */
abstract class APopup extends \XLite\View\FormField\Inline\Base\Single
{

    /**
     * Get popup widget 
     * 
     * @return string
     */
    abstract protected function getPopupWidget();

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        if (!$this->getViewOnly()) {
            $list[] = 'form_field/inline/popup/popup.js';
        }

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'form_field/inline/popup/popup.css';

        return $list;
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' inline-popup';
    }

    /**
     * Get container attributes
     *
     * @return array
     */
    protected function getContainerAttributes()
    {
        $list = parent::getContainerAttributes();

        $list['data-popup-url'] = static::buildURL(
            $this->getPopupTarget(),
            null,
            array('widget' => $this->getPopupWidget()) + $this->getPopupParameters()
        );

        return $list;
    }

    /**
     * Get popup target 
     * 
     * @return string
     */
    protected function getPopupTarget()
    {
        return \XLite::TARGET_DEFAULT;
    }

    /**
     * Get popup parameters 
     * 
     * @return array
     */
    protected function getPopupParameters()
    {
        return array();
    }

}
