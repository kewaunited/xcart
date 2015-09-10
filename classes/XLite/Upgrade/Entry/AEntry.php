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

namespace XLite\Upgrade\Entry;

/**
 * AEntry
 */
abstract class AEntry
{
    /**
     * Some common tokens in messages
     */
    const TOKEN_ENTRY = 'entry';
    const TOKEN_FILE  = 'file';

    /**
     * Path to the unpacked entry archive
     *
     * @var string
     */
    protected $repositoryPath;

    /**
     * List of error messages
     *
     * @var array
     */
    protected $errorMessages = array();

    /**
     * List of modules which require X-Cart premium license
     *
     * @var array
     */
    protected $premiumLicenseModules = array();

    /**
     * List of custom files
     *
     * @var array
     */
    protected $customFiles = array();

    /**
     * List of files and dirs with wrong permissions
     *
     * @var array
     */
    protected $wrongPermissions = array();

    /**
     * List of post rebuild helpers
     *
     * @var array
     */
    protected $postRebuildHelpers;

    /**
     * List of post upgrade notes
     *
     * @var array
     */
    protected $postUpgradeNotes;

    /**
     * List of filepath patterns forbidden for update
     *
     * @var array
     */
    protected $forbiddenPatternsList = null;

    /**
     * Post upgrade actions called flag
     *
     * @var boolean
     */
    protected $postUpgradeActionsCalled = false;

    /**
     * Return entry readable name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Return entry icon URL
     *
     * @return string
     */
    abstract public function getIconURL();

    /**
     * Return entry old major version
     *
     * @return string
     */
    abstract public function getMajorVersionOld();

    /**
     * Return entry old minor version
     *
     * @return string
     */
    abstract public function getMinorVersionOld();

    /**
     * Return entry new major version
     *
     * @return string
     */
    abstract public function getMajorVersionNew();

    /**
     * Return entry new minor version
     *
     * @return string
     */
    abstract public function getMinorVersionNew();

    /**
     * Return entry revision date
     *
     * @return integer
     */
    abstract public function getRevisionDate();

    /**
     * Return module author readable name
     *
     * @return string
     */
    abstract public function getAuthor();

    /**
     * Check if module is enabled
     *
     * @return boolean
     */
    abstract public function isEnabled();

    /**
     * Check if module is installed
     *
     * @return boolean
     */
    abstract public function isInstalled();

    /**
     * Check if module is skin
     *
     * @return boolean
     */
    abstract public function isSkinModule();

    /**
     * Return entry pack size
     *
     * @return integer
     */
    abstract public function getPackSize();

    /**
     * Return entry actual name
     *
     * @return string
     */
    abstract public function getActualName();

    /**
     * Get hashes for current version
     *
     * @return array
     */
    abstract protected function loadHashesForInstalledFiles();

    /**
     * Return path where the upgrade helper scripts are placed
     *
     * @return string
     */
    abstract protected function getUpgradeHelperPath();


    /**
     * Return marketplace ID
     *
     * @return string
     */
    public function getMarketplaceID()
    {
        return hash('md4', $this->getActualName() . $this->getAuthor());
    }

    /**
     * Return entry public icon URL
     *
     * @return string
     */
    public function getPublicIconURL()
    {
        return $this->getIconURL();
    }

    /**
     * Check if module has a custom icon
     *
     * @return boolean
     */
    public function hasIcon()
    {
        return (bool) $this->getPublicIconURL();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        if (0 >= $this->getPackSize()) {
            $this->addErrorMessage('Size of the entry "{{' . self::TOKEN_ENTRY . '}}" pack is zero', true);
        }
    }

    /**
     * Compose version
     *
     * @return string
     */
    public function getVersionOld()
    {
        return \Includes\Utils\Converter::composeVersion($this->getMajorVersionOld(), $this->getMinorVersionOld());
    }

    /**
     * Compose version
     *
     * @return string
     */
    public function getVersionNew()
    {
        return \Includes\Utils\Converter::composeVersion($this->getMajorVersionNew(), $this->getMinorVersionNew());
    }

    /**
     * Perform cleanup
     *
     * @return void
     */
    public function clear()
    {
        $this->setRepositoryPath(null);
    }

    /**
     * Set repository path
     *
     * @param string  $path            Path to set
     * @param boolean $preventCheck    Flag OPTIONAL
     * @param boolean $preventDeletion Flag OPTIONAL
     *
     * @return void
     */
    public function setRepositoryPath($path, $preventCheck = false, $preventDeletion = false)
    {
        if (!empty($path) && !$preventCheck) {
            $path = \Includes\Utils\FileManager::getRealPath($path);

            if (empty($path) || !\Includes\Utils\FileManager::isReadable($path)) {
                $path = null;
            }
        }

        if (!$preventDeletion && !empty($this->repositoryPath) && $path !== $this->repositoryPath) {
            if ($this->isDownloaded()) {
                \Includes\Utils\FileManager::deleteFile($this->repositoryPath);

            } elseif ($this->isUnpacked()) {
                \Includes\Utils\FileManager::deleteFile($this->getCurrentVersionHashesFilePath());
                \Includes\Utils\FileManager::unlinkRecursive($this->repositoryPath);
            }
        }

        $this->repositoryPath = $path;
    }

    /**
     * Get repository path
     *
     * @return string
     */
    public function getRepositoryPath()
    {
        return $this->repositoryPath;
    }

    /**
     * Name of the special file with hashes for installed files
     *
     * @return string
     */
    public function getCurrentVersionHashesFilePath()
    {
        $path = $this->getRepositoryPath();

        if (\Includes\Utils\FileManager::isFile($path)) {
            $path = LC_DIR_TMP . pathinfo($path, \PATHINFO_FILENAME);
        }

        return $path . '.php';
    }

    /**
     * Perform some action after upgrade
     *
     * @return void
     */
    public function setUpgraded()
    {
        $this->setRepositoryPath(LC_DIR_ROOT, false, true);

        if (!isset($this->postRebuildHelpers)) {
            $this->postRebuildHelpers = $this->getHelpers('post_rebuild');
        }

        if (!isset($this->postUpgradeNotes)) {
            $this->postUpgradeNotes = $this->getUpgradeNoteFiles('post_upgrade');
        }
    }

    /**
     * Download package
     *
     * @return boolean
     */
    public function download()
    {
        return $this->isDownloaded();
    }

    /**
     * Unpack archive
     *
     * @return boolean
     */
    public function unpack()
    {
        if ($this->isDownloaded()) {
            // Extract archive files into a new directory
            list($dir, $result) = \Includes\Utils\PHARManager::unpack($this->getRepositoryPath(), LC_DIR_TMP);
            $this->setRepositoryPath($dir, true, !$result);

            if ($result) {
                $this->prepareUnpackDir($dir);
                $this->addFileInfoMessage('Entry "{{' . self::TOKEN_ENTRY . '}}" archive is unpacked', $dir, true);
            }
        }

        return $this->isUnpacked();
    }

    /**
     * Check if pack is already downloaded
     *
     * @return boolean
     */
    public function isDownloaded()
    {
        $path = $this->getRepositoryPath();

        return !empty($path) && \Includes\Utils\FileManager::isExists($path);
    }

    /**
     * Check if archive is already unpacked
     *
     * @return boolean
     */
    public function isUnpacked()
    {
        $path = $this->getRepositoryPath();

        return !empty($path)
            && \Includes\Utils\FileManager::isDir($path)
            && \Includes\Utils\FileManager::isFile($this->getCurrentVersionHashesFilePath());
    }

    /**
     * Names of variables to serialize
     *
     * @return array
     */
    public function __sleep()
    {
        return array(
            'repositoryPath',
            'errorMessages',
            'premiumLicenseModules',
            'customFiles',
            'wrongPermissions',
            'postRebuildHelpers',
            'postUpgradeNotes',
            'postUpgradeActionsCalled',
        );
    }

    /**
     * Check post upgrade actions called flag
     *
     * @return boolean
     */
    public function isPostUpgradeActionsCalled()
    {
        return $this->postUpgradeActionsCalled;
    }

    /**
     * Set post upgrade actions called flag
     *
     * @param boolean $value Value
     *
     * @return void
     */
    public function setPostUpgradeActionsCalled($value = true)
    {
        $this->postUpgradeActionsCalled = $value;
    }

    // {{{ Error handling

    /**
     * Return lst of files and dirs with wrong permissions
     *
     * @return array
     */
    public function getWrongPermissions()
    {
        return array_unique($this->wrongPermissions);
    }

    /**
     * Return list of error messages
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return array_unique($this->errorMessages);
    }

    /**
     * Return list of premium licensed modules
     *
     * @return array
     */
    public function getPremiumLicenseModules()
    {
        return $this->premiumLicenseModules;
    }

    /**
     * Return list of custom files
     *
     * @return array
     */
    public function getCustomFiles()
    {
        return $this->customFiles;
    }

    /**
     * Check for errors
     *
     * @return boolean
     */
    public function isValid()
    {
        return ! (bool) $this->getErrorMessages();
    }

    // }}}

    // {{{ Upgrade

    /**
     * Perform upgrade
     *
     * @param boolean    $isTestMode       Flag OPTIONAL
     * @param array|null $filesToOverwrite List of custom files to overwrite OPTIONAL
     *
     * @return void
     */
    public function upgrade($isTestMode = true, $filesToOverwrite = null)
    {
        $this->errorMessages = array();
        $this->wrongPermissions = array();

        $hashesInstalled  = $this->getHashesForInstalledFiles($isTestMode);
        $hashesForUpgrade = $this->getHashes($isTestMode);

        // Overwrite only selected files or the all ones
        $this->customFiles = is_array($filesToOverwrite) ? $filesToOverwrite : $hashesInstalled;

        // Walk through the installed and known files list
        foreach ($hashesInstalled as $path => &$hash) {
            // Check file on FS
            if ($this->manageFile($path, 'isFile')) {
                // Calculate file md5-hash
                $fileHash = $this->manageFile($path, 'getHash');

                if (isset($fileHash)) {
                    if (isset($hashesForUpgrade[$path])) {
                        // File has been modified (by user, or by LC Team, see the third param)
                        if ($fileHash !== $hashesForUpgrade[$path] && !$this->isUpdateForbiddenForFilePath($path)) {
                            $this->updateFile($path, $isTestMode, $fileHash !== $hash);
                        }

                    } else {
                        // File has been removed (by user, or by LC Team, see the third param)
                        $this->deleteFile($path, $isTestMode, $fileHash !== $hash);
                    }

                } else {
                    // Do not skip any files during upgrade: all of them must be writable
                    $this->addFileErrorMessage('File is not readable', $path, !$isTestMode);
                }

            } elseif (isset($hashesForUpgrade[$path])) {
                // File has been removed from installation (by user)
                $this->addFile($path, $isTestMode, true);
            }

            // Only the new files will remain
            unset($hashesForUpgrade[$path]);
        }

        // Add new files
        foreach ($hashesForUpgrade as $path => $hash) {
            $this->addFile(
                $path,
                $isTestMode,
                $this->manageFile($path, 'isFile') && $this->manageFile($path, 'getHash') !== $hash
            );
        }

        // Clear some data
        if (!$isTestMode) {
            $this->customFiles = array();
        }
    }

    /**
     * Do specific directory preparations after unpacking
     *
     * @param string $dir Directory
     *
     * @return void
     */
    protected function prepareUnpackDir($dir)
    {
    }

    /**
     * Perform some common operation for upgrade
     *
     * @param string  $path              File short path
     * @param boolean $isTestMode        If in test mode
     * @param boolean $manageCustomFiles Flag for custom files
     *
     * @return void
     */
    protected function addFile($path, $isTestMode, $manageCustomFiles)
    {
        $this->modifyFile($path, $isTestMode, $manageCustomFiles, 'addFileCallback');
    }

    /**
     * Perform some common operation for upgrade
     *
     * @param string  $path              File short path
     * @param boolean $isTestMode        If in test mode
     * @param boolean $manageCustomFiles Flag for custom files
     *
     * @return void
     */
    protected function updateFile($path, $isTestMode, $manageCustomFiles)
    {
        $this->modifyFile($path, $isTestMode, $manageCustomFiles, 'updateFileCallback');
    }

    /**
     * Perform some common operation for upgrade
     *
     * @param string  $path              File short path
     * @param boolean $isTestMode        If in test mode
     * @param boolean $manageCustomFiles Flag for custom files
     *
     * @return void
     */
    protected function deleteFile($path, $isTestMode, $manageCustomFiles)
    {
        $this->modifyFile($path, $isTestMode, $manageCustomFiles, 'deleteFileCallback');
    }

    /**
     * Callback for a common operation for upgrade
     *
     * @param string  $path       File short path
     * @param boolean $isTestMode If in test mode
     *
     * @return void
     */
    protected function addFileCallback($path, $isTestMode)
    {
        if ($isTestMode) {
            // Short names
            $topDir  = $this->manageFile($path, 'getDir');
            $lcRoot  = \Includes\Utils\FileManager::getRealPath(LC_DIR_ROOT);
            $sysRoot = \Includes\Utils\FileManager::getRealPath('/');

            // Search for writable directory
            while (!\Includes\Utils\FileManager::isDir($topDir) && $topDir !== $lcRoot && $topDir !== $sysRoot) {
                $topDir = \Includes\Utils\FileManager::getDir($topDir);
            }

            // Permissions are invalid
            if (!\Includes\Utils\FileManager::isDirWriteable($topDir)) {
                $this->addFileErrorMessage(
                    'Directory is not writable: "{{dir}}"',
                    $path,
                    false,
                    array('dir' => $topDir)
                );
                $this->wrongPermissions[] = $topDir;
            }

        } else {
            $source = $this->getFileSource($path);

            if ($source !== null) {
                if ($this->manageFile($path, 'write', array($source))) {
                    $this->addFileInfoMessage('File is added', $path, true);

                } else {
                    $this->addFileErrorMessage('Unable to add file', $path, true);
                }
            } else {
                $this->addFileErrorMessage('Unable to read file while adding', $path, true);
            }
        }
    }

    /**
     * Callback for a common operation for upgrade
     *
     * @param string  $path       File short path
     * @param boolean $isTestMode If in test mode
     *
     * @return void
     */
    protected function updateFileCallback($path, $isTestMode)
    {
        if ($isTestMode) {
            if (!$this->manageFile($path, 'isFileWriteable')) {
                $this->addFileErrorMessage('File is not writeable', $path, false);
                $this->wrongPermissions[] = $this->getFullPath($path);
            }

        } else {
            $source = $this->getFileSource($path);

            if ($source) {
                if ($this->manageFile($path, 'write', array($source))) {
                    $this->addFileInfoMessage('File is updated', $path, true);

                } else {
                    $this->addFileErrorMessage('Unable to update file', $path, true);
                }

            } else {
                $this->addFileErrorMessage('Unable to read file while updating', $path, true);
            }
        }
    }

    /**
     * Callback for a common operation for upgrade
     *
     * @param string  $path       File short path
     * @param boolean $isTestMode If in test mode
     *
     * @return void
     */
    protected function deleteFileCallback($path, $isTestMode)
    {
        if ($isTestMode) {
            if (!\Includes\Utils\FileManager::isDirWriteable($this->manageFile($path, 'getDir'))) {
                $this->addFileErrorMessage('File\'s directory is not writable', $path, false);
                $this->wrongPermissions[] = $this->manageFile($path, 'getDir');
            }
        } elseif ($this->manageFile($path, 'deleteFile')) {
            $this->addFileInfoMessage('File is deleted', $path, true);
            // Remove the parent directory if upgrade process removes all files in it
            $dir = dirname($path);
            if (\Includes\Utils\FileManager::isEmptyDir($dir)) {
                \Includes\Utils\FileManager::unlinkRecursive($dir);

                if (!\Includes\Utils\FileManager::isExists($dir)) {
                    $this->addFileInfoMessage('Directory is deleted', $dir, true);

                } else {
                    $this->addFileInfoMessage('Unable to delete directory', $dir, true);
                }
            }

        } else {
            $this->addFileErrorMessage('Unable to delete file', $path, true);
        }
    }

    /**
     * Common operation for add/update/delete
     *
     * :TODO: advise a more convinient logic for this method
     *
     * @param string  $path              File short path
     * @param boolean $isTestMode        If in test mode
     * @param boolean $manageCustomFiles Flag for custom files
     * @param string  $callback          Callback to execute
     *
     * @return void
     */
    protected function modifyFile($path, $isTestMode, $manageCustomFiles, $callback)
    {
        if ($isTestMode) {
            if ($manageCustomFiles) {
                $this->addToCustomFiles($path);
            }

            // Call a specific class method
            $this->$callback($path, $isTestMode);

        } elseif (!$manageCustomFiles || $this->checkForCustomFileRewrite($path)) {
            // Call a specific class method
            $this->$callback($path, $isTestMode);
        }
    }

    /**
     * Short name for FileManager call
     *
     * @param string $path   File short path
     * @param string $method Method to call
     * @param array  $args   Call arguments OPTIONAL
     *
     * @return mixed
     */
    protected function manageFile($path, $method, array $args = array())
    {
        return call_user_func_array(
            array('\Includes\Utils\FileManager', $method),
            array_merge(array($this->getFullPath($path)), $args)
        );
    }

    /**
     * Compose file full path
     *
     * @param string $path    File short path
     * @param string $baseDir Bae dir OPTIONAL
     *
     * @return string
     */
    protected function getFullPath($path, $baseDir = LC_DIR_ROOT)
    {
        return $baseDir . $path;
    }

    /**
     * Add file to the custom files list
     *
     * @param string  $path File short path
     * @param boolean $flag Status OPTIONAL
     *
     * @return void
     */
    protected function addToCustomFiles($path, $flag = true)
    {
        $this->customFiles[$path] = $flag;
    }

    /**
     * Check status of custom file entry list
     *
     * @param string $path File short path
     *
     * @return boolean
     */
    protected function checkForCustomFileRewrite($path)
    {
        return !empty($this->customFiles[$path]);
    }

    /**
     * Add the module entry information into inner premium licensed modules collection
     *
     * @return void
     */
    protected function addToPremiumLicenseModules()
    {
        $this->premiumLicenseModules[$this->getActualName()] = $this;
    }

    /**
     * Return file hashes
     *
     * @param boolean $isTestMode Flag
     *
     * @return array
     */
    protected function getHashes($isTestMode)
    {
        $path = \Includes\Utils\FileManager::getCanonicalDir($this->getRepositoryPath()) . '.hash';

        if (!\Includes\Utils\FileManager::isFileReadable($path)) {
            $message = 'Hash file for new entry "{{entry}}" doesn\'t exist or is not readable';

        } else {
            $data = \Includes\Utils\FileManager::read($path);

            if (empty($data)) {
                $message = 'Unable to read hash file for new entry "{{entry}}" (or it\'s empty)';

            } else {
                $data = json_decode($data, true);

                if (is_array($data)) {
                    foreach ($data as $path => $hash) {
                        // :TRICKY: "str_replace()" call is the hack for modules,
                        // which are packed on Windows servers, but installing on *NIX
                        unset($data[$path]);
                        $data[str_replace('\\', LC_DS, $path)] = $hash;
                    }

                } else {
                    $message = 'Hash file for new entry "{{entry}}" has a wrong format';
                }
            }
        }

        if (!empty($message)) {
            $this->addFileErrorMessage($message, $path, !$isTestMode);
        }

        return (empty($data) || !is_array($data)) ? array() : $data;
    }

    /**
     * Return file hashes for the currently installed version
     *
     * @param boolean $isTestMode Flag
     *
     * @return array
     */
    protected function getHashesForInstalledFiles($isTestMode)
    {
        if ($this->isInstalled()) {
            $path = $this->getCurrentVersionHashesFilePath();

            if (!\Includes\Utils\FileManager::isFileReadable($path)) {
                $message = 'Hash file for installed entry "{{entry}}" doesn\'t exist or is not readable';

            } else {
                require_once $path;
            }

            if (!empty($message)) {
                $this->addFileErrorMessage($message, $path, !$isTestMode);
            }
        }

        return (empty($data) || !is_array($data)) ? array() : $data;
    }

    /**
     * Save hashes for current version
     *
     * @return void
     */
    protected function saveHashesForInstalledFiles()
    {
        $data = $this->loadHashesForInstalledFiles();

        if (is_array($data)) {
            \Includes\Utils\FileManager::write(
                $this->getCurrentVersionHashesFilePath(),
                '<?php' . PHP_EOL . '$data = ' . var_export($data, true) . ';'
            );
        }
    }

    /**
     * Return true if specified file should not be updated
     *
     * @param string $path File path
     *
     * @return boolean
     */
    protected function isUpdateForbiddenForFilePath($path)
    {
        // preg_filter() will return null if $path does not match to any pattern
        return null !== preg_filter($this->getForbiddenFilePathPatterns(), array(), '/' . ltrim($path, '/'));
    }

    /**
     * Get patterns for filepaths excluded from update procedure
     *
     * @return array
     */
    protected function getForbiddenFilePathPatterns()
    {
        if (!isset($this->forbiddenPatternsList)) {
            $this->forbiddenPatternsList = array();

            foreach ($this->getForbiddenPathsList() as $path) {
                $this->forbiddenPatternsList[] = '/' . preg_quote($path, '/') . '/';
            }
        }

        return $this->forbiddenPatternsList;
    }

    /**
     * Get list of file paths which are forbidden for update if user already changed them
     *
     * @return array
     */
    protected function getForbiddenPathsList()
    {
        return array(
            '/skins/common/images/flags_svg/',
        );
    }

    /**
     * Read file from package
     *
     * @param string $relativePath File relative path in package
     *
     * @return string
     */
    protected function getFileSource($relativePath)
    {
        $source = null;
        $path   = \Includes\Utils\FileManager::getCanonicalDir($this->getRepositoryPath());

        if (!empty($path)) {
            $path = \Includes\Utils\FileManager::getRealPath($this->getFullPath($relativePath, $path));
        }

        if (!empty($path)) {
            $source = \Includes\Utils\FileManager::read($path);
        }

        return $source;
    }

    // }}}

    // {{{ So called upgrade helpers

    /**
     * Execute some methods
     *
     * @param string $type Helper type
     *
     * @return void
     */
    public function runHelpers($type)
    {
        $path = \Includes\Utils\FileManager::getCanonicalDir($this->getRepositoryPath());

        // Helpers must examine itself if the module has been installed previously
        if ($path) {
            $helpers = ('post_rebuild' === $type) ? $this->postRebuildHelpers : $this->getHelpers($type);
            $helpers = (array) $helpers;

            foreach ($helpers as $file) {
                /** @var \Closure $function */
                $function = require_once $path . $file;
                $function();

                $this->addInfoMessage(
                    'Update hook is run: {{type}}:{{file}}',
                    true,
                    array('type' => $this->getActualName(), 'file' => $file)
                );
            }

            if ($helpers) {
                \XLite\Core\Database::getCacheDriver()->deleteAll();
            }
        }
    }

    /**
     * Execute common helper method
     *
     * @param string $type Helper type
     *
     * @return void
     */
    public function runCommonHelpers($type)
    {
        $method = 'runCommonHelper' . \Includes\Utils\Converter::convertToCamelCase($type);

        if (method_exists($this, $method)) {
            // Run common helper method
            $this->$method();
        }
    }

    /**
     * Call install event
     *
     * @return void
     */
    public function callInstallEvent()
    {
    }

    /**
     * Returns upgrade notes
     *
     * @param string $type Note type
     *
     * @return array
     */
    public function getUpgradeNotes($type)
    {
        $noteFiles = ('post_upgrade' === $type) ? $this->postUpgradeNotes : $this->getUpgradeNoteFiles($type);
        $notes = array();

        if ($noteFiles) {
            foreach ($noteFiles as $file) {
                $data = $this->getFileSource($file);

                $notes[] = $this->prepareUpgradeNote($data);
            }
        }

        return $notes;
    }

    /**
     * Run common helper method 'add_labels': load labels from yaml file
     *
     * @return void
     */
    protected function runCommonHelperAddLabels()
    {
        $yamlFiles = $this->getCommonHelperAddLabelsFiles();

        if (!is_array($yamlFiles)) {
            $yamlFiles = array($yamlFiles);
        }

        if ($yamlFiles) {
            // Load data from yaml files
            foreach ($yamlFiles as $yamlFile) {
                $areLabelsLoaded = \XLite\Core\Translation::getInstance()->loadLabelsFromYaml($yamlFile);
            }

            // Reset cache of language translations
            \XLite\Core\Translation::getInstance()->reset();

            $this->addInfoMessage(
                'Common update hook \'add_labels\' is run for {{name}} (labels were {{result}})',
                true,
                array('name' => $this->getActualName(), 'result' => $areLabelsLoaded ? 'uploaded' : 'not uploaded')
            );
        }
    }

    /**
     * Get yaml files name to run common helper 'add_labels'
     *
     * @return string
     */
    protected function getCommonHelperAddLabelsFiles()
    {
        return null;
    }

    /**
     * Get upgrade helpers list
     *
     * @param string $type Helper type
     *
     * @return array
     */
    protected function getHelpers($type)
    {
        $helpers = array();

        foreach ($this->getUpgradeHelperMajorVersions() as $majorVersion) {
            foreach ($this->getUpgradeHelperMinorVersions($majorVersion) as $minorVersion) {
                $file = $this->getUpgradeHelperFile($type, $majorVersion, $minorVersion);
                if ($file) {
                    $helpers[] = $file;
                }
            }
        }

        return $helpers;
    }

    /**
     * Get upgrade notes files list
     *
     * @param string $type Helper type
     *
     * @return array
     */
    protected function getUpgradeNoteFiles($type)
    {
        $notes = array();
        $language = \Xlite::getController()->getCurrentLanguage();

        foreach ($this->getUpgradeHelperMajorVersions() as $majorVersion) {
            foreach ($this->getUpgradeHelperMinorVersions($majorVersion) as $minorVersion) {
                $file = $this->getUpgradeNoteFile($type, $majorVersion, $minorVersion, $language);
                if (empty($file)) {
                    $file = $this->getUpgradeNoteFile($type, $majorVersion, $minorVersion);
                }

                if ($file) {
                    $notes[] = $file;
                }
            }
        }

        return $notes;
    }

    /**
     * Wrapper for the abstract method
     *
     * @param mixed $getFullPath Flag OPTIONAL
     *
     * @return string
     */
    protected function getUpgradeHelpersDir($getFullPath = true)
    {
        $path = \Includes\Utils\FileManager::getCanonicalDir($this->getRepositoryPath());

        if (!empty($path)) {
            $dir = $this->getUpgradeHelperPath() . 'upgrade' . LC_DS;
        }

        return \Includes\Utils\FileManager::isDir($path . $dir) ? ($getFullPath ? $path : '') . $dir : null;
    }

    /**
     * Get file with an upgrade helper function
     *
     * @param string $type         Helper type
     * @param string $majorVersion Major version to upgrade to
     * @param string $minorVersion Minor version to upgrade to
     *
     * @return string
     */
    protected function getUpgradeHelperFile($type, $majorVersion, $minorVersion)
    {
        $file = null;
        $path = $this->getUpgradeHelpersDir();

        if ($path) {
            $file = $majorVersion . LC_DS . $minorVersion . LC_DS . $type . '.php';

            if (\Includes\Utils\FileManager::isFile($path . $file)) {
                $file = $this->getUpgradeHelpersDir(false) . $file;

            } else {
                $file = null;
            }
        }

        return $file;
    }

    /**
     * Get file with an upgrade note
     *
     * @param string $type         Note type
     * @param string $majorVersion Major version to upgrade to
     * @param string $minorVersion Minor version to upgrade to
     * @param string $languageCode Language code OPTIONAL
     *
     * @return string
     */
    protected function getUpgradeNoteFile($type, $majorVersion, $minorVersion, $languageCode = null)
    {
        $file = null;
        $path = $this->getUpgradeHelpersDir();

        if ($path) {
            $language = (isset($languageCode) ? ('.' . $languageCode) : '');
            $file = $majorVersion . LC_DS . $minorVersion . LC_DS . $type . $language . '.txt';

            if (\Includes\Utils\FileManager::isFile($path . $file)) {
                $file = $this->getUpgradeHelpersDir(false) . $file;

            } else {
                $file = null;
            }
        }

        return $file;
    }

    /**
     * Prepare upgrade note
     *
     * @param string $note Upgrade note
     *
     * @return string
     */
    protected function prepareUpgradeNote($note)
    {
        $note = htmlspecialchars($note);

        return nl2br($note);
    }

    /**
     * Get list of available major versions for the helpers
     *
     * @return array
     */
    protected function getUpgradeHelperMajorVersions()
    {
        $old = $this->getMajorVersionOld();
        $new = $this->getMajorVersionNew();

        return array_filter(
            $this->getUpgradeHelperVersions(),
            function ($var) use ($old, $new) {
                return version_compare($old, $var, '<=') && version_compare($new, $var, '>=');
            }
        );
    }

    /**
     * Get list of available minor versions for the helpers
     *
     * @param string $majorVersion Current major version
     *
     * @return array
     */
    protected function getUpgradeHelperMinorVersions($majorVersion)
    {
        $new = \Includes\Utils\Converter::composeVersion($this->getMajorVersionNew(), $this->getMinorVersionNew());

        $oldMajorVersion = $this->getMajorVersionOld();
        $oldMinorVersion = $this->getMinorVersionOld();

        $old = (strlen($oldMajorVersion) && strlen($oldMinorVersion))
            ? \Includes\Utils\Converter::composeVersion($oldMajorVersion, $oldMinorVersion)
            : $new;

        return array_filter(
            $this->getUpgradeHelperVersions($majorVersion . LC_DS),
            function ($var) use ($majorVersion, $old, $new) {
                $version = \Includes\Utils\Converter::composeVersion($majorVersion, $var);

                return version_compare($old, $version, '<') && version_compare($new, $version, '>=');
            }
        );
    }

    /**
     * Get list of available versions for the helpers
     *
     * @param string $path Path to scan OPTIONAL
     *
     * @return array
     */
    protected function getUpgradeHelperVersions($path = null)
    {
        $result = array();
        $dir = $this->getUpgradeHelpersDir();

        if ($dir) {
            foreach (new \DirectoryIterator($dir . $path) as $fileinfo) {
                if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                    $result[] = $fileinfo->getFilename();
                }
            }

            if (!usort($result, 'version_compare')) {
                $result = array();
            }
        }

        return $result;
    }

    // }}}

    // {{{ Logging and error handling

    /**
     * Add new info message
     *
     * @param string  $message Message to add
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addInfoMessage($message, $log, array $args = array())
    {
        $this->addMessage('Info', $message, $log, $args);
    }

    /**
     * Add new error message
     *
     * @param string  $message Message to add
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addErrorMessage($message, $log, array $args = array())
    {
        $this->addMessage('Error', $message, $log, $args);

        // Add message to the internal array
        $this->errorMessages[] = \XLite\Core\Translation::getInstance()->translate($message, $args);
    }

    /**
     * Add new info message which contains file path
     *
     * @param string  $message Message to add
     * @param string  $file    File path
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addFileInfoMessage($message, $file, $log, array $args = array())
    {
        $this->addFileMessage('Info', $message, $file, $log, $args);
    }

    /**
     * Add new error message which contains file path
     *
     * @param string  $message Message to add
     * @param string  $file    File path
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addFileErrorMessage($message, $file, $log, array $args = array())
    {
        $this->addFileMessage('Error', $message, $file, $log, $args);
    }

    /**
     * Add new message
     *
     * @param string  $method  Logger method to call
     * @param string  $message Message to add
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addMessage($method, $message, $log, array $args = array())
    {
        // It's a quite common case
        $args += array(self::TOKEN_ENTRY => $this->getActualName());

        // Write message to the log (if needed)
        if (!empty($log)) {
            \XLite\Upgrade\Logger::getInstance()->{'log' . $method}($message, $args, false);
        }
    }

    /**
     * Add new error message which contains file path
     *
     * @param string  $method  Logger method to call
     * @param string  $message Message to add
     * @param string  $file    File path
     * @param boolean $log     Flag
     * @param array   $args    Substitution arguments OPTIONAL
     *
     * @return void
     */
    protected function addFileMessage($method, $message, $file, $log, array $args = array())
    {
        $this->{'add' . $method . 'Message'}(
            $message . ': "{{' . self::TOKEN_FILE . '}}"',
            $log,
            $args + array(self::TOKEN_FILE => $file)
        );
    }

    // }}}
}
