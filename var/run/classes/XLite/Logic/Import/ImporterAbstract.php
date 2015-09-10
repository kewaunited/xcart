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

namespace XLite\Logic\Import;

/**
 * Importer
 */
abstract class ImporterAbstract extends \XLite\Base
{
    /**
     * Default import directory
     */
    const IMPORT_DIR = 'import';

    const DEFAULT_CHARSET = 'UTF-8';

    const MAX_FILE_SIZE = 500000;

    /**
     * Language code
     *
     * @var string
     */
    static protected $languageCode;

    /**
     * Options
     *
     * @var   \ArrayObject
     */
    protected $options;

    /**
     * Steps (cache)
     *
     * @var   array
     */
    protected $steps;

    /**
     * Import processors list (cache)
     *
     * @var   array
     */
    protected $processors;

    /**
     * Constructor
     *
     * @param array $options Options OPTIONAL
     */
    public function __construct(array $options = array())
    {
        $this->options = array(
            'step'             => isset($options['step']) ? intval($options['step']) : 0,
            'position'         => isset($options['position']) ? intval($options['position']) : 0,
            'charset'          => !empty($options['charset']) ? $options['charset'] : static::DEFAULT_CHARSET,
            'delimiter'        => isset($options['delimiter']) ? $options['delimiter'] : ',',
            'enclosure'        => isset($options['enclosure']) ? $options['enclosure'] : '"',
            'files'            => isset($options['files']) ? $options['files'] : array(),
            'linkedFiles'      => isset($options['linkedFiles']) ? $options['linkedFiles'] : array(),
            'deltaFiles'       => isset($options['deltaFiles']) ? $options['deltaFiles'] : array(),
            'clearImportDir'     => isset($options['clearImportDir']) ? $options['clearImportDir'] : false,
            'ignoreFileChecking' => isset($options['ignoreFileChecking']) ? $options['ignoreFileChecking'] : false,
            'dir'              => isset($options['dir']) ? $options['dir'] : static::getImportDir(),
            'time'             => isset($options['time']) ? intval($options['time']) : 0,
            'columnsMetaData'  => isset($options['columnsMetaData']) ? $options['columnsMetaData'] : array(),
            'errorsCount'      => isset($options['errorsCount']) ? $options['errorsCount'] : 0,
            'warningsCount'    => isset($options['warningsCount']) ? $options['warningsCount'] : 0,
            'rowsCount'        => isset($options['rowsCount']) ? $options['rowsCount'] : 0,
            'warningsAccepted' => isset($options['warningsAccepted']) ? $options['warningsAccepted'] : false,
            // 'calculateAllQuickData' => isset($options['calculateAllQuickData']) ? $options['calculateAllQuickData'] : false,
        ) + $options;

        static::$languageCode = isset($options['languageCode'])
            ? $options['languageCode']
            : \XLite\Core\Config::getInstance()->General->default_admin_language;

        $this->options = new \ArrayObject($this->options, \ArrayObject::ARRAY_AS_PROPS);

        if (0 == $this->getOptions()->step && 0 == $this->getOptions()->position) {
            $this->initialize();
        }
    }

    /**
     * Get language code
     *
     * @return string
     */
    public static function getLanguageCode()
    {

        return static::$languageCode;
    }

    /**
     * Set language code
     *
     * @param string $code Code
     *
     * @return void
     */
    public static function setLanguageCode($code)
    {

        static::$languageCode = $code;
    }

    /**
     * Run
     *
     * @param array $options Options
     *
     * @return void
     */
    public static function run(array $options)
    {
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setVar(static::getImportCancelFlagVarName(), false);
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setVar(static::getImportUserBreakFlagVarName(), false);
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->initializeEventState(
            static::getEventName(),
            array('options' => $options)
        );
        \XLite\Core\EventTask::import();
        call_user_func(array('\XLite\Core\EventTask', static::getEventName()));
    }

    /**
     * Cancel import routine
     *
     * @return void
     */
    public static function cancel()
    {
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setVar(static::getImportCancelFlagVarName(), true);
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setVar(static::getImportUserBreakFlagVarName(), false);
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->removeEventState(static::getEventName());
    }

    /**
     * Break import routine
     *
     * @return void
     */
    public static function userBreak()
    {
        \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setVar(static::getImportUserBreakFlagVarName(), true);
    }

    /**
     * Finalize
     *
     * @return void
     */
    public function finalize()
    {
        if (!isset($this->getOptions()->commonData)) {
            $this->getOptions()->commonData = array();
        }
        $this->getOptions()->commonData['finalize'] = true;
    }

    /**
     * Initialize
     *
     * @return void
     */
    protected function initialize()
    {
        $dir = \Includes\Utils\FileManager::getRealPath(LC_DIR_VAR . $this->getOptions()->dir);

        // Unpack
        foreach ($this->getOptions()->files as $path) {
            if (\XLite\Core\Archive::getInstance()->isArchive($path)) {
                \XLite\Core\Archive::getInstance()->unpack($path, $dir, true);
                $this->getOptions()->linkedFiles[$path] = \XLite\Core\Archive::getInstance()->getList($path);
            }
        }

        // Delete all logs
        \XLite\Core\Database::getRepo('XLite\Model\ImportLog')->clearAll();

        // Convert charsets
        if (static::DEFAULT_CHARSET != $this->getOptions()->charset) {
            $iconv = \XLite\Core\Iconv::getInstance();
            foreach ($this->getCSVList() as $file) {
                $iconv->convertFile(
                    $this->getOptions()->charset,
                    static::DEFAULT_CHARSET,
                    $file->getPathname()
                );
            }
        }

        // Preprocess import data
        if ($this->preprocessImport()) {
            // Save import options if they were changed
            $record = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState('import');
            $record['state'] = \XLite\Core\EventTask::STATE_IN_PROGRESS;
            $record['options'] = $this->getOptions()->getArrayCopy();
            \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->setEventState('import', $record);
        }
    }

    /**
     * Preprocess import data.
     * Check size limit of CSV files and divide them on several small parts.
     * Returns true if file was divided
     *
     * @return boolean
     */
    protected function preprocessImport()
    {
        $newFiles = array();

        foreach ($this->getProcessors() as $processor) {
            $files = $processor->getFiles(true);
            foreach ($files as $file) {
                $fileSize = $file->getSize();

                if ($fileSize > static::MAX_FILE_SIZE) {
                    $newFiles[$file->getRealPath()] = $processor->divideCSVFile($file);
                }
            }
        }

        if ($newFiles) {
            $dir = \Includes\Utils\FileManager::getRealPath(LC_DIR_VAR . $this->getOptions()->dir);

            foreach ($newFiles as $srcFile => $dstFiles) {
                if (\Includes\Utils\FileManager::deleteFile($srcFile)) {
                    foreach ($dstFiles as $fileData) {
                        $moveTo = $dir . LC_DS . basename($fileData['file']);
                        \Includes\Utils\FileManager::move($fileData['file'], $moveTo);
                        $this->options->deltaFiles[basename($moveTo)] = array(
                            'delta' => $fileData['delta'],
                            'file'  => basename($srcFile),
                        );
                    }
                }
            }
        }

        return !empty($newFiles);
    }

    /**
     * Get options
     *
     * @return \ArrayObject
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Check importer state
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->getStep() && $this->getStep()->isValid() && !$this->hasErrors();
    }

    /**
     * Check importer state
     *
     * @return boolean
     */
    public function isImportAllowed()
    {
        return $this->valid() && (!static::hasWarnings() || $this->getOptions()->warningsAccepted);
    }

    /**
     * Check - next step allowed or not
     *
     * @return boolean
     */
    public function isNextStepAllowed()
    {
        return $this->getStep()->isStepDone()
            && !static::hasErrors()
            && (!static::hasWarnings() || $this->getOptions()->warningsAccepted)
            && empty($this->getOptions()->commonData['finalize'])
            && $this->detectNextStep($this->getOptions()->step);
    }

    /**
     * Switch to next step
     *
     * @param array $options Additional options OPTIONAL
     *
     * @return boolean
     */
    public function switchToNextStep(array $options = array())
    {
        $result = false;

        $base = $this->getOptions()->getArrayCopy();
        $options = array_merge(
            static::assembleImportOptions($base),
            static::assembleCommonImportOptions($base),
            $options
        );
        $options['step'] = $this->detectNextStep($base['step']);
        if (isset($options['step'])) {
            static::run($options);
            $result = true;
        }

        return $result;
    }

    /**
     * Detect next step
     *
     * @param integer $index Current step index
     *
     * @return integer
     */
    protected function detectNextStep($index)
    {
        $steps = $this->getSteps();
        $length = count($steps);
        do {
            $index++;
            $step = (isset($steps[$index]) && $steps[$index]->isAllowed())
                ? $index
                : null;

        } while ($index < $length && !$step);

        return $step;
    }

    // {{{ Options

    /**
     * Get list of import options
     *
     * @return array
     */
    public static function getImportOptionsList()
    {
        return array(
            'ignoreFileChecking',
            'charset',
            'delimiter',
        );
    }

    /**
     * Get list of common import options
     *
     * @return array
     */
    public static function getCommonImportOptionsList()
    {
        return array(
            'commonData'       => array(),
            'columnsMetaData'  => array(),
            'warningsAccepted' => false,
        );
    }

    /**
     * Assemble import options
     *
     * @param array $options Options OPTIONAL
     *
     * @return array
     */
    public static function assembleImportOptions(array $options = array())
    {
        $result = array();

        foreach (static::getImportOptionsList() as $key) {
            $result[$key] = isset($options[$key])
                ? $options[$key]
                : \XLite\Core\Config::getInstance()->Import->$key;
        }

        return $result;
    }

    /**
     * Assemble common import options
     *
     * @param array $options Options OPTIONAL
     *
     * @return array
     */
    public static function assembleCommonImportOptions(array $options = array())
    {
        $result = array();

        foreach (static::getCommonImportOptionsList() as $key => $default) {
            $result[$key] = isset($options[$key])
                ? $options[$key]
                : $default;
        }

        return $result;
    }

    // }}}

    // {{{ Steps

    /**
     * Get step
     *
     * @return \XLite\Logic\Import\Step\AStep
     */
    public function getStep()
    {
        $steps = $this->getSteps();

        return isset($steps[$this->getOptions()->step]) ? $steps[$this->getOptions()->step] : null;
    }

    /**
     * Get steps
     *
     * @return array
     */
    public function getSteps()
    {
        if (!isset($this->steps)) {
            $this->steps = $this->defineSteps();
            $this->processSteps();
        }

        return $this->steps;
    }

    /**
     * Sort steps
     *
     * @param \XLite\Logic\Import\Step\AStep $a First
     * @param \XLite\Logic\Import\Step\AStep $b Second
     *
     * @return integer
     */
    public function sortSteps(\XLite\Logic\Import\Step\AStep $a, \XLite\Logic\Import\Step\AStep $b)
    {
        $aw = $a->getWeight();
        $bw = $b->getWeight();

        if ($aw > $bw) {
            $result = 1;

        } elseif ($aw < $bw) {
            $result = -1;

        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * Define steps
     *
     * @return array
     */
    protected function defineSteps()
    {
        return array(
            'XLite\Logic\Import\Step\Verification',
            'XLite\Logic\Import\Step\Import',
            'XLite\Logic\Import\Step\QuickData',
            'XLite\Logic\Import\Step\ImageResize',
        );
    }

    /**
     * Process steps
     *
     * @return void
     */
    protected function processSteps()
    {
        foreach ($this->steps as $i => $stepClass) {
            $this->steps[$i] = new $stepClass($this, $i);
            $this->steps[$i]->setDefaultWeight(($i + 1) * 100);
        }

        usort($this->steps, array($this, 'sortSteps'));

        $this->steps = array_values($this->steps);
    }

    // }}}

    // {{{ Processors

    /**
     * Get processors
     *
     * @return array
     */
    public function getProcessors()
    {
        if (!isset($this->processors)) {
            $this->processors = $this->getProcessorList();
            $this->prepareProcessors();
        }

        return $this->processors;
    }

    /**
     * Get processor list
     *
     * @return array
     */
    public static function getProcessorList()
    {
        return array(
            'XLite\Logic\Import\Processor\Attributes',
            'XLite\Logic\Import\Processor\Categories',
            'XLite\Logic\Import\Processor\Products',
            'XLite\Logic\Import\Processor\Customers',
            'XLite\Logic\Import\Processor\AttributeValues\AttributeValueCheckbox',
            'XLite\Logic\Import\Processor\AttributeValues\AttributeValueSelect',
            'XLite\Logic\Import\Processor\AttributeValues\AttributeValueText',
        );
    }

    /**
     * Prepare processors
     *
     * @return void
     */
    protected function prepareProcessors()
    {
        foreach ($this->processors as $i => $processor) {
            if (\XLite\Core\Operator::isClassExists($processor)) {
                $this->processors[$i] = new $processor($this);

            } else {
                unset($this->processors[$i]);
            }
        }

        $this->processors = array_values($this->processors);
    }

    // }}}

    // {{{ Error / warning routines

    /**
     * Check - import process has warnings or not
     *
     * @return boolean
     */
    public static function hasWarnings()
    {
        return 0 < \XLite\Core\Database::getRepo('XLite\Model\ImportLog')
            ->countBy(array('type' => \XLite\Model\ImportLog::TYPE_WARNING));
    }

    /**
     * Check - import process has errors or not
     *
     * @return boolean
     */
    public static function hasErrors()
    {
        return 0 < \XLite\Core\Database::getRepo('XLite\Model\ImportLog')
            ->countBy(array('type' => \XLite\Model\ImportLog::TYPE_ERROR));
    }

    // }}}

    // {{{ Filesystem

    /**
     * Get CSV files list
     *
     * @return \Includes\Utils\FileFilter\FilterIterator
     */
    public function getCSVList()
    {
        if (!isset($this->csvFilter)) {
            $dir = \Includes\Utils\FileManager::getRealPath(LC_DIR_VAR . $this->getOptions()->dir);

            $this->csvFilter = new \Includes\Utils\FileFilter($dir, '/\.csv$/Ss');
        }

        return $this->csvFilter->getIterator();
    }

    /**
     * Delete all files
     *
     * @return void
     */
    public function deleteAllFiles()
    {
        $dir = \Includes\Utils\FileManager::getRealPath(LC_DIR_VAR . $this->getOptions()->dir);

        if (!\Includes\Utils\FileManager::isExists($dir)) {
            \Includes\Utils\FileManager::mkdir($dir);
        }

        $list = glob($dir . LC_DS . '*');
        if ($list) {
            foreach ($list as $path) {
                if (is_file($path)) {
                    \Includes\Utils\FileManager::deleteFile($path);

                } else {
                    \Includes\Utils\FileManager::unlinkRecursive($path);
                }
            }
        }
    }

    /**
     * Get import directory path
     *
     * @return string
     */
    public static function getImportDir()
    {
        return static::IMPORT_DIR;
    }

    // }}}

    // {{{ Service variable names

    /**
     * Get import cancel flag name
     *
     * @return string
     */
    public static function getImportCancelFlagVarName()
    {
        return 'importCancelFlag';
    }

    /**
     * Get import user break flag name
     *
     * @return string
     */
    public static function getImportUserBreakFlagVarName()
    {
        return 'importUserBreak';
    }

    /**
     * Get import event name
     *
     * @return string
     */
    public static function getEventName()
    {
        return 'import';
    }

    // }}}
}
