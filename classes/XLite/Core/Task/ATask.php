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

namespace XLite\Core\Task;

/**
 * Abstract task
 */
abstract class ATask extends \XLite\Base
{
    /**
     * Model
     *
     * @var \XLite\Model\Task
     */
    protected $model;

    /**
     * Last step flag
     *
     * @var boolean
     */
    protected $lastStep = false;

    /**
     * Result operation message
     *
     * @var string
     */
    protected $message = 'done';

    /**
     * Get title
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Run step
     *
     * @return void
     */
    abstract protected function runStep();

    /**
     * Constructor
     *
     * @param \XLite\Model\Task $model Model
     *
     * @return void
     */
    public function __construct(\XLite\Model\Task $model)
    {
        $this->model = $model;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Check - task ready or not
     *
     * @return boolean
     */
    public function isReady()
    {
        return true;
    }

    /**
     * Should task started if previous attempt has failed
     * 
     * @return boolean
     */
    public function shouldRunIfCrashed()
    {
        return true;
    }

    /**
     * Lock key
     * 
     * @return string
     */
    public function getLockKey()
    {
        return get_class() . $this->model->getId();
    }

    /**
     * Check - task ready or not
     *
     * @return boolean
     */
    public function isRunning()
    {
        return \XLite\Core\Lock\FileLock::getInstance()->isRunning(
            $this->getLockKey(),
            !$this->shouldRunIfCrashed()
        );
    }

    /**
     * Mark task as running
     * 
     * @return void
     */
    protected function markAsRunning()
    {
        \XLite\Core\Lock\FileLock::getInstance()->setRunning(
            $this->getLockKey()
        );
    }

    /**
     * mark as not running
     * 
     * @return void
     */
    protected function release()
    {
        \XLite\Core\Lock\FileLock::getInstance()->release(
            $this->getLockKey()
        );
    }

    /**
     * Run task
     *
     * @return boolean
     */
    public function run()
    {
        $result = null;

        if ($this->isValid()) {
            $this->prepareStep();

            $this->markAsRunning();

            $this->runStep();

            if ($this->isLastStep()) {
                $this->finalizeTask();

            } else {
                $this->finalizeStep();
            }

        } elseif (!$this->message) {
            $this->message = 'invalid';
        }
    }

    /**
     * Prepare step
     *
     * @return void
     */
    protected function prepareStep()
    {
    }

    /**
     * Check - current step is last or not
     * 
     * @return boolean
     */
    protected function isLastStep()
    {
        return $this->lastStep;
    }

    /**
     * Finalize task (last step)
     *
     * @return void
     */
    protected function finalizeTask()
    {
        $this->release();
        $this->close();
    }

    /**
     * Finalize step
     *
     * @return void
     */
    protected function finalizeStep()
    {
    }

    /**
     * Check availability
     *
     * @return boolean
     */
    protected function isValid()
    {
        return true;
    }

    /**
     * Close task
     *
     * @return void
     */
    protected function close()
    {
        \XLite\Core\Database::getEM()->remove($this->model);
    }
}
