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

namespace XLite\View\Button;

/**
 * File selector popup button
 */
class FileSelector extends \XLite\View\Button\APopupButton
{
    /**
     * Name of object to link uploaded file (e.g. equal to 'product', 'category')
     */
    const PARAM_OBJECT = 'object';

    /**
     * Identificator of linked object.
     */
    const PARAM_OBJECT_ID = 'objectId';

    /**
     * Name of the uploaded file object (e.g. 'image', 'icon', 'file')
     */
    const PARAM_FILE_OBJECT = 'fileObject';

    /**
     * Identificator of the uploaded file object. Used if file must be substituted (update action)
     */
    const PARAM_FILE_OBJECT_ID = 'fileObjectId';

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/file_selector.js';
        // TODO: dynamic JS inclusion
        $list[] = 'button/js/browse_server.js';

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
        $list[] = 'file_selector/style.css';
        // TODO: dynamic CSS inclusion
        $list[] = 'browse_server/style.css';

        return $list;
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        return array(
            'target'        => 'select_file',
            'object'        => $this->getParam(static::PARAM_OBJECT),
            'objectId'      => $this->getParam(static::PARAM_OBJECT_ID),
            'fileObject'    => $this->getParam(static::PARAM_FILE_OBJECT),
            'fileObjectId'  => $this->getParam(static::PARAM_FILE_OBJECT_ID),
            'widget'        => '\XLite\View\FileSelectorDialog',
        );
    }

    /**
     * Return default button label
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'File upload';
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_OBJECT          => new \XLite\Model\WidgetParam\String('Object', 'product'),
            static::PARAM_OBJECT_ID       => new \XLite\Model\WidgetParam\Int('Object ID', 0),
            static::PARAM_FILE_OBJECT     => new \XLite\Model\WidgetParam\String('File object', 'image'),
            static::PARAM_FILE_OBJECT_ID  => new \XLite\Model\WidgetParam\Int('File object ID', 0),
        );
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' file-selector-button';
    }
}
