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
 * Cache management page controller
 */
class CacheManagement extends \XLite\Controller\Admin\Settings
{
    /**
     * Values to use for $page identification
     */
    const CACHE_MANAGEMENT_PAGE = 'CacheManagement';

    /**
     * Resize
     *
     * @var \XLite\Logic\QuickData\Generator
     */
    protected $quickDataGenerator;

    /**
     * Page
     *
     * @var string
     */
    public $page = self::CACHE_MANAGEMENT_PAGE;

    /**
     * Define the actions with no secure token
     *
     * @return array
     */
    public static function defineFreeFormIdActions()
    {
        return LC_DEVELOPER_MODE
            ? array_merge(parent::defineFreeFormIdActions(), array('rebuild'))
            : parent::defineFreeFormIdActions();
    }

    /**
     * doActionRebuild
     *
     * @return void
     */
    public function doActionRebuild()
    {
        \XLite::setCleanUpCacheFlag(true);

        // To avoid the infinite loop
        $this->setReturnURL($this->buildURL());
    }

    /**
     * Get tab names
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        $list[static::CACHE_MANAGEMENT_PAGE] = static::t('Cache management');

        return $list;
    }

    /**
     * Get resize
     *
     * @return \XLite\Logic\QuickData\Generator
     */
    public function getQuickDataGenerator()
    {
        if (null === $this->quickDataGenerator) {
            $eventName = \XLite\Logic\QuickData\Generator::getEventName();
            $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($eventName);
            $this->quickDataGenerator = ($state && isset($state['options']))
                ? new \XLite\Logic\QuickData\Generator($state['options'])
                : false;
        }

        return $this->quickDataGenerator;
    }

    /**
     * Check - export process is not-finished or not
     *
     * @return boolean
     */
    public function isQuickDataNotFinished()
    {
        $eventName = \XLite\Logic\QuickData\Generator::getEventName();
        $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($eventName);

        return $state
            && in_array(
                $state['state'],
                array(\XLite\Core\EventTask::STATE_STANDBY, \XLite\Core\EventTask::STATE_IN_PROGRESS)
            )
            && !\XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getVar($this->getQuickDataCancelFlagVarName());
    }

    /**
     * Perform some actions before redirect
     *
     * FIXME: check. Action should not be an optional param
     *
     * @param string|null $action Performed action OPTIONAL
     *
     * @return void
     */
    protected function actionPostprocess($action = null)
    {
        parent::actionPostprocess($action);

        $this->setReturnURL(
            $this->buildURL('cache_management')
        );
    }

    /**
     * Export action
     *
     * @return void
     */
    protected function doActionQuickData()
    {
        \XLite\Logic\QuickData\Generator::run($this->assembleQuickDataOptions());
    }

    /**
     * Assemble export options
     *
     * @return array
     */
    protected function assembleQuickDataOptions()
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
    protected function doActionQuickDataCancel()
    {
        \XLite\Logic\QuickData\Generator::cancel();
    }

    /**
     * Preprocessor for no-action run
     *
     * @return void
     */
    protected function doNoAction()
    {
        $request = \XLite\Core\Request::getInstance();

        if ($request->quick_data_completed) {
            \XLite\Core\TopMessage::addInfo('The calculation of quick data has been completed successfully.');

            $this->setReturnURL(
                $this->buildURL('cache_management')
            );

        } elseif ($request->quick_data_failed) {
            \XLite\Core\TopMessage::addError('The calculation of quick data has been stopped.');

            $this->setReturnURL(
                $this->buildURL('cache_management')
            );
        }
    }

    /**
     * Get export cancel flag name
     *
     * @return string
     */
    protected function getQuickDataCancelFlagVarName()
    {
        return \XLite\Logic\QuickData\Generator::getQuickDataCancelFlagVarName();
    }
}
