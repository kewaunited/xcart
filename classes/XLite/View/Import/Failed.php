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

namespace XLite\View\Import;

/**
 * Failed section
 */
class Failed extends \XLite\View\AView
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'import/failed.tpl';
    }

    /**
     * Return true if import process has errors
     *
     * @return boolean
     */
    protected function hasErrors()
    {
        return \XLite\Logic\Import\Importer::hasErrors();
    }

    /**
     * Return true if import process has been broken by user
     *
     * @return boolean
     */
    protected function isBroken()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getVar(\XLite\Logic\Import\Importer::getImportUserBreakFlagVarName());
    }

    /**
     * Return true if 'Proceed' button should be displayed
     *
     * @return boolean
     */
    protected function isDisplayProceedButton()
    {
        return !$this->hasErrors() && !$this->isBroken();
    }

    /**
     * Return files list
     *
     * @return array
     */
    protected function getFiles()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\ImportLog')->findFiles();
    }

    /**
     * Return errors list
     *
     * @param string $file File
     *
     * @return array
     */
    protected function getErrors($file)
    {
        return \XLite\Core\Database::getRepo('XLite\Model\ImportLog')->findErrorsByFile($file);
    }

    /**
     * Return errors list grouped
     *
     * @param string $file File
     *
     * @return array
     */
    protected function getErrorsGroups($file)
    {
        $errors = $this->getErrors($file);
        $result = array();
        array_walk(
            $errors,
            function($error) use (&$result){
                $uniqueHash = md5($error['code'] . serialize($error['arguments']));
                if (!array_key_exists($uniqueHash, $result)) {
                    $result[$uniqueHash] = array(
                        'code'      => $error['code'],
                        'type'      => $error['type'],
                        'arguments' => $error['arguments'],
                        'errors'    => array()
                    );
                }
                $result[$uniqueHash]['errors'][] = $error;
            }
        );
        return $result;
    }

    /**
     * Return title
     *
     * @return string 
     */
    protected function getTitle()
    {
        return static::t(
            'The script found {{number}} errors during verification',
            array(
                'number' => \XLite\Core\Database::getRepo('XLite\Model\ImportLog')->count()
            )
        );
    }

    /**
     * Return error message 
     *
     * @param array $error Error 
     *
     * @return string 
     */
    protected function getErrorMessage($error)
    {
        $messages = $this->getErrorMessages();

        $result = static::t(
            'Row {{number}}',
            array('number' => $error['row'])
        );

        $result .= ': ';

        $result .= isset($messages[$error['code']])
            ? static::t($messages[$error['code']], is_array($error['arguments']) ? $error['arguments'] : array())
            : $error['code'];

        return $result;
    }

    /**
     * Return group error message 
     *
     * @param array $error Error 
     *
     * @return string 
     */
    protected function getGroupErrorMessage($errorGroup)
    {
        $messages = $this->getErrorMessages();

        $result = isset($messages[$errorGroup['code']])
            ? static::t($messages[$errorGroup['code']], is_array($errorGroup['arguments']) ? $errorGroup['arguments'] : array())
            : $errorGroup['code'];
        $rows = array_map(function($error){
            return $error['row'];
        }, $errorGroup['errors']);

        return $result;
    }

    /**
     * Return group error rows 
     *
     * @param array $error Error 
     *
     * @return string 
     */
    protected function getGroupErrorRows($errorGroup)
    {
        $rows = array_map(function($error){
            return $error['row'];
        }, $errorGroup['errors']);
        return static::t(
            'Row(s) {{numbers}}',
            array('numbers' => implode(', ', array_unique($rows)))
        );
    }

    /**
     * Return error text
     *
     * @param array $error Error 
     *
     * @return string 
     */
    protected function getErrorText($error)
    {
        $texts = $this->getErrorTexts();

        return isset($texts[$error['code']])
            ? static::t($texts[$error['code']]) 
            : ('E' == $error['type'] ? static::t('Critical error') : static::t('Warning'));
    }

    /**
     * Return error messages
     *
     * @return array 
     */
    protected function getErrorMessages()
    {
        $result = array();

        foreach (\XLite\Logic\Import\Importer::getProcessorList() as $processor) {
            $result = array_merge($result, $processor::getMessages());
        }

        return $result;
    }

    /**
     * Return error texts
     *
     * @return array 
     */
    protected function getErrorTexts()
    {
        $result = array();

        foreach (\XLite\Logic\Import\Importer::getProcessorList() as $processor) {
            $result = array_merge($result, $processor::getErrorTexts());
        }

        return $result;
    }
}
