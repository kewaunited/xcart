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

namespace XLite\Controller\Admin;

/**
 * Images page controller
 */
abstract class ImagesAbstract extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Resize
     *
     * @var \XLite\Logic\ImageResize\Generator
     */
    protected $imageResizeGenerator = null;

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Images');
    }

    /**
     * Do action 'Update'
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $list = new \XLite\View\ItemsList\Model\ImagesSettings();
        $list->processQuick();
    }

    // {{{ Image resize methods

    /**
     * Get resize
     *
     * @return \XLite\Logic\ImageResize\Generator
     */
    public function getImageResizeGenerator()
    {
        if (!isset($this->imageResizeGenerator)) {
            $eventName = \XLite\Logic\ImageResize\Generator::getEventName();
            $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($eventName);
            $this->imageResizeGenerator = ($state && isset($state['options']))
                ? new \XLite\Logic\ImageResize\Generator($state['options'])
                : false;
        }

        return $this->imageResizeGenerator;
    }

    /**
     * Check - export process is not-finished or not
     *
     * @return boolean
     */
    public function isImageResizeNotFinished()
    {
        $eventName = \XLite\Logic\ImageResize\Generator::getEventName();
        $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($eventName);

        return $state
            && in_array(
                $state['state'],
                array(\XLite\Core\EventTask::STATE_STANDBY, \XLite\Core\EventTask::STATE_IN_PROGRESS)
            )
            && !\XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getVar($this->getImageResizeCancelFlagVarName());
    }

    /**
     * Export action
     *
     * @return void
     */
    protected function doActionImageResize()
    {
        \XLite\Logic\ImageResize\Generator::run($this->assembleImageResizeOptions());
    }

    /**
     * Assemble export options
     *
     * @return array
     */
    protected function assembleImageResizeOptions()
    {
        $request = \XLite\Core\Request::getInstance();

        return array(
            'include' => $request->section,
        );
    }

    /**
     * Cancel
     *
     * @return void
     */
    protected function doActionImageResizeCancel()
    {
        \XLite\Logic\ImageResize\Generator::cancel();
    }

    /**
     * Preprocessor for no-action run
     *
     * @return void
     */
    protected function doNoAction()
    {
        $request = \XLite\Core\Request::getInstance();

        if ($request->resize_completed) {
            \XLite\Core\TopMessage::addInfo('The generation of resized images has been completed successfully.');

            $this->setReturnURL(
                $this->buildURL('images')
            );

        } elseif ($request->resize_failed) {
            \XLite\Core\TopMessage::addError('The generation of resized images has been stopped.');

            $this->setReturnURL(
                $this->buildURL('images')
            );
        }
    }

    /**
     * Get export cancel flag name
     *
     * @return string
     */
    protected function getImageResizeCancelFlagVarName()
    {
        return \XLite\Logic\ImageResize\Generator::getResizeCancelFlagVarName();
    }

    // }}}
}
