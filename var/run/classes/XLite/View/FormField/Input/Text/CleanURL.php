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

namespace XLite\View\FormField\Input\Text;

/**
 * Clean URL
 */
class CleanURL extends \XLite\View\FormField\Input\Text
{
    const PARAM_OBJECT_CLASS_NAME = 'objectClassName';
    const PARAM_OBJECT_ID_NAME    = 'objectIdName';
    const PARAM_OBJECT_ID         = 'objectId';
    const PARAM_EXTENSION         = 'extension';

    /**
     * Conflict object
     *
     * @var \XLite\Model\AEntity
     */
    protected $conflict = null;

    /**
     * Prepare request data (typecasting)
     *
     * @param mixed $value Value
     *
     * @return mixed
     */
    public function prepareRequestData($value)
    {
        $data = preg_replace('/\.' . $this->getExtension() . '$/', '', parent::prepareRequestData($value));

        return $data . ($this->getExtension() ? '.' . $this->getExtension() : '');
    }

    /**
     * Return field value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->prepareRequestData(parent::getValue());
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
            self::PARAM_OBJECT_CLASS_NAME => new \XLite\Model\WidgetParam\String('Object class name'),
            self::PARAM_OBJECT_ID_NAME    => new \XLite\Model\WidgetParam\String('Object Id name', 'id'),
            self::PARAM_OBJECT_ID    => new \XLite\Model\WidgetParam\Int('Object Id'),
            self::PARAM_EXTENSION         => new \XLite\Model\WidgetParam\String('Extension', ''),
        );
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return '/input/text/clean_url.tpl';
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/input/text/clean_url.js';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/input/text/clean_url.css';

        return $list;
    }

    /**
     * Assemble validation rules
     *
     * @return array
     */
    protected function assembleValidationRules()
    {
        $rules = parent::assembleValidationRules();
        $rules[] = 'maxSize[' . $this->getParam(self::PARAM_MAX_LENGTH) . ']';

        return $rules;
    }

    /**
     * Check field validity
     *
     * @return boolean
     */
    protected function checkFieldValidity()
    {
        $result = parent::checkFieldValidity();

        if ($result
            && $this->getValue()
        ) {
            $validator = new \XLite\Core\Validator\String\CleanURL(
                false,
                null,
                $this->getParam(self::PARAM_OBJECT_CLASS_NAME),
                $this->getObjectId()
            );
            try {
                $validator->validate($this->getValue());

            } catch (\XLite\Core\Validator\Exception $exception) {
                $result = false;
                $this->errorMessage = static::t($exception->getMessage(), $exception->getLabelArguments());

                if ($exception->getData()->conflict) {
                    $this->conflict = $exception->getData()->conflict;
                }
            }
        }

        return $result;
    }

    /**
     * Check if CleanURL functionality is disabled
     *
     * @return boolean
     */
    protected function isCleanURLDisabled()
    {
        return !LC_USE_CLEAN_URLS;
    }

    /**
     * Return extension
     *
     * @return string
     */
    protected function getExtension()
    {
        return $this->getParam(static::PARAM_EXTENSION);
    }

    /**
     * Return true if extension is present
     *
     * @return boolean
     */
    protected function hasExtension()
    {
        return '' !== $this->getParam(static::PARAM_EXTENSION);
    }

    /**
     * Get fake URL
     *
     * @return string
     */
    protected function getFakeURL()
    {
        $className = $this->getParam(static::PARAM_OBJECT_CLASS_NAME);
        $id = $this->getObjectId();

        $entity = \Xlite\Core\Database::getRepo($className)->find($id);
        /** @var \XLite\Model\Repo\CleanURL $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\CleanURL');

        return \XLite::getInstance()->getShopURL($repo->buildFakeURL($entity));
    }

    /**
     * Get fake URL
     *
     * @return string
     */
    protected function getURL()
    {
        $className = $this->getParam(static::PARAM_OBJECT_CLASS_NAME);
        $id = $this->getObjectId();

        /** @var \XLite\Model\Repo\CleanURL $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\CleanURL');

        return \XLite::getInstance()->getShopURL(
            $repo->buildURL(
                $className,
                array($this->getParam(static::PARAM_OBJECT_ID_NAME) => $id)
            )
        );
    }

    /**
     * Get saved value
     *
     * @return string
     */
    protected function getSavedValue()
    {
        $className = $this->getParam(static::PARAM_OBJECT_CLASS_NAME);
        $id = $this->getObjectId();

        $entity = \Xlite\Core\Database::getRepo($className)->find($id);

        return $entity ? $entity->getCleanURL() : '';
    }

    /**
     * Is conflict object present
     *
     * @return boolean
     */
    protected function hasConflict()
    {
        return isset($this->conflict);
    }

    /**
     * Is conflict in history
     *
     * @return bool
     */
    protected function isHistoryConflict()
    {
        return $this->hasConflict()
            && $this->conflict->getCleanURL() !== $this->getValue();
    }

    /**
     * Returns resolve hint
     *
     * @return string
     */
    protected function getResolveHint()
    {
        $hints = array();

        $hints[] = static::t('Change the Clean URL value for this page');

        if ($this->isHistoryConflict()) {
            $hints[] = static::t('Enable the Force Clean URL option to unassign the Clean URL from the page it is currently used for and apply it to this page.');
        }

        return sprintf('<ul><li>' . implode('</li><li>', $hints) . '</li></ul>');
    }

    /**
     * Returns object id
     *
     * @return integer
     */
    protected function getObjectId()
    {
        return $this->getParam(static::PARAM_OBJECT_ID)
            ? $this->getParam(static::PARAM_OBJECT_ID)
            : \XLite\Core\Request::getInstance()->{$this->getParam(static::PARAM_OBJECT_ID_NAME)};
    }
}
