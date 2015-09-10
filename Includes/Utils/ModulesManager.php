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

namespace Includes\Utils;

/**
 * Some useful constants
 */
define('LC_DS_QUOTED', preg_quote(LC_DS, '/'));
define('LC_DS_OPTIONAL', '(' . LC_DS_QUOTED . '|$)');

/**
 * ModulesManager
 *
 */
abstract class ModulesManager extends \Includes\Utils\AUtils
{
    /**
     * Pattern to get module name by class name
     */
    const CLASS_NAME_PATTERN = '/(?:\\\)?XLite\\\Module\\\(\w+\\\\\w+)(\\\|$)/USs';

    /**
     * Modules list file name
     */
    const MODULES_FILE_NAME = '.decorator.modules.ini.php';
    const XC_FREE_LICENSE_KEY = 'XC5-FREE-LICENSE';

    /**
     * Restore point date internal format
     */
    const RESTORE_DATE_FORMAT = 'Y_m_d_H_i_s';

    /**
     * List of active modules
     *
     * @var array
     */
    protected static $activeModules;

    /**
     * Data for class tree walker
     *
     * @var array
     */
    protected static $quotedPaths;

    /**
     * Get modules migration log file name
     *
     * @return string
     */
    protected static function getModuleMigrationLogFile()
    {
        return LC_DIR_SERVICE . '.modules.migrations.php';
    }


    // {{{ Name convertion routines

    /**
     * Get class name by module name
     *
     * @param string $moduleName Module actual name
     *
     * @return string
     */
    public static function getClassNameByModuleName($moduleName)
    {
        return '\XLite\Module\\' . $moduleName . '\Main';
    }

    /**
     * Retrieve module name from class name
     *
     * @param string $className Class name to parse
     *
     * @return string
     */
    public static function getModuleNameByClassName($className)
    {
        return preg_match(static::CLASS_NAME_PATTERN, $className, $matches) ? $matches[1] : null;
    }

    /**
     * Compose module actual name
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return string
     */
    public static function getActualName($author, $name)
    {
        return $author . '\\' . $name;
    }

    /**
     * Compose module class name by module author and name
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return string
     */
    public static function getClassNameByAuthorAndName($author, $name)
    {
        return static::getClassNameByModuleName(static::getActualName($author, $name));
    }

    /**
     * Return module relative dir
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return string
     */
    public static function getRelativeDir($author, $name)
    {
        return $author . LC_DS . $name . LC_DS;
    }

    /**
     * Return module absolute dir
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return string
     */
    public static function getAbsoluteDir($author, $name)
    {
        return LC_DIR_MODULES . static::getRelativeDir($author, $name);
    }

    /**
     * Return module icon file path
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return string
     */
    public static function getModuleIconFile($author, $name)
    {
        return static::getModuleImageFile($author, $name, 'icon.png');
    }

    /**
     * Return module icon file path
     *
     * @param string $author Module author
     * @param string $name   Module name
     * @param string $image  Image name
     *
     * @return string
     */
    public static function getModuleImageFile($author, $name, $image)
    {
        return static::getAbsoluteDir($author, $name) . $image;
    }

    /**
     * Return module YAML file path
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return array
     */
    public static function getModuleYAMLFiles($author, $name)
    {
        $result = array();
        $dir = static::getAbsoluteDir($author, $name);

        $result[] = $dir . 'install.yaml';

        foreach ((array) glob($dir . 'install_*.yaml') as $translationFile) {
            $result[] = $translationFile;
        }

        return $result;
    }

    /**
     * Get module by file name
     *
     * @param string $file File name
     *
     * @return string
     */
    public static function getFileModule($file)
    {
        $pattern = '/classes' . LC_DS_QUOTED . 'XLite' . LC_DS_QUOTED . 'Module' . LC_DS_QUOTED
            . '(\w+)' . LC_DS_QUOTED . '(\w+)' . LC_DS_QUOTED . '/Si';

        return preg_match($pattern, $file, $matches) ? ($matches[1] . '\\' . $matches[2]) : null;
    }

    // }}}

    // {{{ Methods to access installed module main class

    /**
     * Initialize active modules
     *
     * @return void
     */
    public static function initModules()
    {
        foreach (static::getActiveModules() as $module => $data) {
            static::callModuleMethod($module, 'init');
        }
    }

    /**
     * Check if module is installed
     *
     * @param string $module Module actual name
     *
     * @return boolean
     */
    public static function isModuleInstalled($module)
    {
        return \Includes\Utils\Operator::checkIfClassExists(static::getClassNameByModuleName($module));
    }

    /**
     * Method to access module main clas methods
     *
     * @param string $module Module actual name
     * @param string $method Method to call
     * @param array  $args   Call arguments OPTIONAL
     *
     * @return mixed
     */
    public static function callModuleMethod($module, $method, array $args = array())
    {
        $result = null;

        if (static::isModuleInstalled($module)) {
            $result = call_user_func_array(array(static::getClassNameByModuleName($module), $method), $args);
        }

        return $result;
    }

    /**
     * Get module info from it's main class
     *
     * @param string $author         Module author
     * @param string $name           Module name
     * @param array  $additionalData Data to add to result OPTIONAL
     *
     * @return array
     */
    protected static function getModuleDataFromClass($author, $name, array $additionalData = array())
    {
        $module = static::getActualName($author, $name);

        $result = array(
            'name'            => $name,
            'author'          => $author,
            'enabled'         => intval(static::isActiveModule($module)),
            'installed'       => 1,
            'yamlLoaded'      => 0,
            'date'            => time(),
            'fromMarketplace' => 0,
            'isSystem'        => intval(static::callModuleMethod($module, 'isSystem')),
            'majorVersion'    => static::callModuleMethod($module, 'getMajorVersion'),
            'minorVersion'    => static::callModuleMethod($module, 'getMinorVersion'),
            'minorRequiredCoreVersion' => static::callModuleMethod($module, 'getMinorRequiredCoreVersion'),
            'moduleName'      => static::callModuleMethod($module, 'getModuleName'),
            'authorName'      => static::callModuleMethod($module, 'getAuthorName'),
            'authorEmail'     => '',
            'description'     => static::callModuleMethod($module, 'getDescription'),
            'iconURL'         => static::callModuleMethod($module, 'getIconURL'),
            'pageURL'         => static::callModuleMethod($module, 'getPageURL'),
            'authorPageURL'   => static::callModuleMethod($module, 'getAuthorPageURL'),
            'dependencies'    => serialize((array) static::callModuleMethod($module, 'getDependencies')),
            'tags'            => serialize(array()),
            'rating'          => 0,
            'votes'           => 0,
            'downloads'       => 0,
            'price'           => 0.00,
            'currency'        => 'USD',
            'revisionDate'    => 0,
            'packSize'        => 0,
            'editions'        => serialize(array()),
            'editionState'    => 0,
            'xcnPlan'         => 0,
            'hasLicense'      => 0,
            'isLanding'       => 0,
            'landingPosition' => 0,
            'xbProductId'     => 0,
        );

        return array_replace_recursive($result, $additionalData);
    }

    // }}}

    // {{{ Active modules

    /**
     * Return list of active modules (or check a single module)
     *
     * @return array
     */
    public static function getActiveModules()
    {
        static::readModuleMigrationLog();
        if (!isset(static::$activeModules)) {

            // Fetch enabled modules from the common list
            $enabledModules = \Includes\Utils\ArrayManager::searchAllInArraysArray(
                static::getModulesList(),
                'enabled',
                true
            );

            // Fetch system modules from the disabled modules list
            $systemModules = static::getSystemModules();

            // Get full list of active modules
            static::$activeModules = $enabledModules + $systemModules;

            // Remove unsupported modules from list
            static::checkVersions();

            // Remove unsafe modules
            static::performSafeModeProtection();

            // Remove modules with corrupted dependencies
            static::correctDependencies();
        }

        return static::$activeModules;
    }

    /**
     * Check if module is active
     *
     * @param string|null $moduleName Module name
     *
     * @return boolean
     */
    public static function isActiveModule($moduleName)
    {
        return (bool) \Includes\Utils\ArrayManager::getIndex(static::getActiveModules(), $moduleName, true);
    }

    /**
     * Check if module is inactive
     *
     * @param string|null $moduleName Module name
     *
     * @return boolean
     */
    public static function isInactiveModule($moduleName)
    {
        return !static::isActiveModule($moduleName);
    }

    /**
     * Check if all modules are active
     *
     * @param array $moduleNames Module names
     *
     * @return boolean
     */
    public static function areActiveModules(array $moduleNames)
    {
        return array_filter(array_map(array('static', 'isActiveModule'), $moduleNames)) == $moduleNames;
    }

    /**
     * Check if all modules are inactive
     *
     * @param array $moduleNames Module names
     *
     * @return boolean
     */
    public static function areInactiveModules(array $moduleNames)
    {
        return array_filter(array_map(array('static', 'isInactiveModule'), $moduleNames)) == $moduleNames;
    }

    /**
     * Get the list of disabled system modules
     *
     * @return array
     */
    protected static function getSystemModules()
    {
        $modules = array();

        if (!\Includes\Utils\ConfigParser::getOptions(array('performance', 'ignore_system_modules'))) {
            foreach (static::getModulesList() as $module => $data) {
                if (static::callModuleMethod($module, 'isSystem')) {
                    $modules[$module] = $data;
                }
            }
        }

        return $modules;
    }

    /**
     * Disable modules with non-correct versions
     *
     * @return void
     */
    protected static function checkVersions()
    {
        $checkLicense = static::getLicenseFlag();
        foreach (static::$activeModules as $module => $data) {
            if (
                \XLite::getInstance()->checkVersion(static::callModuleMethod($module, 'getMajorVersion'), '!=')
                || (
                    \XLite::getInstance()->checkVersion(static::callModuleMethod($module, 'getMajorVersion'), '=')
                    && \XLite::getInstance()->checkMinorVersion(static::callModuleMethod($module, 'getMinorRequiredCoreVersion'), '<')
                )
                || static::checkEdition($data, $checkLicense)
            ) {
                static::disableModule($module);
            }
        }
    }

    /**
     * Disable some (or all) modules in SafeMode
     *
     * @return void
     */
    protected static function performSafeModeProtection()
    {
        if (\Includes\SafeMode::isSafeModeStarted()) {
            if (!\Includes\SafeMode::isRestoreDateSet()) {                
                // Get unsafe modules list
                $modules = \Includes\SafeMode::isSoftResetRequested()
                    ? \Includes\SafeMode::getUnsafeModulesList()
                    : array_keys(static::$activeModules);
            } else {
                $restorePoint = static::getRestorePoint(\Includes\SafeMode::getRestoreDate());
                if (!empty($restorePoint)) {
                    //modules to disable
                    $modules = array();
                    $active = static::getActiveModules();
                    foreach ($active as $key => $module) {
                        $toDisable = true;
                        foreach ($restorePoint['current'] as $id => $moduleName) {
                            if ($moduleName != null && $key === $moduleName) {
                                $moduleName = null;
                                $toDisable = false;
                                break;
                            }
                        }
                        if ($toDisable){
                            $modules[] = $key;
                        }
                    }             

                    //modules to enable
                    $toEnable = array();
                    $installed = static::getModulesList();
                    foreach ($restorePoint['current'] as $id => $moduleName) {
                        $isInstalled = array_key_exists($moduleName, $installed);
                        $isActive = array_key_exists($moduleName, $active);
                        if($isInstalled && !$isActive){
                            $toEnable[] = $moduleName;
                        }
                    }

                    // Enable modules         
                    array_walk($toEnable, array('static', 'enableModule'));

                    $date = \DateTime::createFromFormat(static::RESTORE_DATE_FORMAT, $restorePoint["date"]);
                    \Includes\Decorator\Utils\PersistentInfo::set('restoredTo', $date->getTimestamp());

                    $restorationRecord = static::getRestorationRecord($restorePoint["date"]);
                    static::updateModuleMigrationLog($restorationRecord);
                }                
            }

            // Disable modules
            array_walk($modules, array('static', 'disableModule'));

            \Includes\SafeMode::cleanupIndicator();
        }
    }

    /**
     * Disable modules with incorrect dependencies
     *
     * @return void
     */
    protected static function correctDependencies()
    {
        $dependencies = array();

        foreach (static::$activeModules as $module => $data) {
            $dependencies = array_merge_recursive(
                $dependencies,
                array_fill_keys(static::callModuleMethod($module, 'getDependencies'), $module)
            );
        }

        $dependencies = array_diff_key($dependencies, static::$activeModules);
        array_walk_recursive($dependencies, array('static', 'disableModule'));

        // http://bugtracker.qtmsoft.com/view.php?id=41330
        static::excludeMutualModules();
    }

    /**
     * Disable so called "mutual exclusive" modules
     *
     * @return void
     */
    protected static function excludeMutualModules()
    {
        $list = array();

        foreach (static::$activeModules as $module => $data) {
            $list = array_merge_recursive($list, static::callModuleMethod($module, 'getMutualModulesList'));
        }

        array_walk_recursive($list, array('static', 'disableModule'));
    }

    /**
     * Check if the table is existed
     *
     * @param string $table Table name without DB prefix (short notation)
     *
     * @return boolean
     */
    protected static function checkTable($table)
    {
        $result = \Includes\Utils\Database::fetchAll('SHOW TABLES LIKE \'' . get_db_tables_prefix() . $table . '\'');

        return !empty($result);
    }

    /**
     * Check if the license is free
     *
     * @return boolean
     */
    protected static function getLicenseFlag()
    {
        return 'Free' == static::getLicense();
    }

    /**
     * Check if the license is free
     *
     * @return boolean
     */
    protected static function getLicense()
    {
        $license = '';

        if (static::checkTable('module_keys')) {
            $key = \Includes\Utils\Database::fetchAll(
                'SELECT keyData FROM ' . get_db_tables_prefix() . 'module_keys WHERE name=\'Core\' AND author=\'CDev\''
            );

            if ($key && isset($key[0])) {
                $keyData = unserialize($key[0]['keyData']);
                $license = isset($keyData['editionName']) ? $keyData['editionName'] : '';
            }
        }

        return $license;
    }


    /**
     * Defines if the module must be disabled according license flag
     *
     * @param array   $module      Module
     * @param boolean $licenseFlag License flag
     *
     * @return boolean
     */
    protected static function checkEdition($module, $licenseFlag)
    {
        $result = false;

        if ($licenseFlag) {
            $marketplaceModule = static::getMarketplaceModule($module);
            if ($marketplaceModule) {
                $edition = unserialize($marketplaceModule['editions']);
                if (empty($edition)) {
                    $result = false;
                } else {
                    $result = !in_array(static::getLicense(), $edition);
                }
            }
        }

        return $result;
    }


    /**
     * Retrive the marketplace module for the given one
     *
     * @param array $module Module array structure
     *
     * @return array
     */
    protected static function getMarketplaceModule($module)
    {
        $marketplaceModule = \Includes\Utils\Database::fetchAll(
            'SELECT * FROM ' . static::getTableName() . ' WHERE name= ? AND author= ? AND fromMarketplace= ?',
            array($module['name'], $module['author'], 1)
        );

        return empty($marketplaceModule) ? null : $marketplaceModule[0];
    }

    // }}}

    // {{{ Methods to manage module states (installed/enabled)

    /**
     * Set module enabled flag fo "false"
     *
     * @param string $key Module actual name (key)
     *
     * @return boolean
     */
    public static function disableModule($key)
    {
        if (isset(static::$activeModules[$key]) && !static::callModuleMethod($key, 'isSystem')) {

            // Short names
            $data = static::$activeModules[$key];
            $path = static::getModulesFilePath();

            // Check if "xlite_modules" table exists
            if (\Includes\Utils\FileManager::isFileReadable($path)) {

                // Set flag in .ini-file
                $pattern = '/(\[' . $data['author'] . '\][^\[]+\s*' . $data['name'] . '\s*=)\s*\S+/Ss';
                \Includes\Utils\FileManager::replace($path, '$1 0', $pattern);

            } else {

                // Set flag in DB.
                // This operation is highly NOT recommended in the usual workflow!
                // All info for this module must be stored before that!
                $query = 'UPDATE ' . static::getTableName() . ' SET enabled = ? WHERE moduleID = ?';
                \Includes\Utils\Database::execute($query, array(0, $data['moduleID']));

            }

            // Move the registry entry info into DISABLED registry to prevent LOST information
            static::moveModuleToDisabledRegistry($data['author'] . '\\' . $data['name']);

            // Remove from local cache
            unset(static::$activeModules[$key]);
        }
    }

    /**
     * Set module enabled flag fo "false"
     *
     * @param string $key Module actual name (key)
     *
     * @return boolean
     */
    public static function enableModule($key)
    {
        $installed = static::getModulesList();
        if (!isset(static::$activeModules[$key]) && isset($installed[$key]) && !static::callModuleMethod($key, 'isSystem')) {
            // Short names
            $data = $installed[$key];
            $path = static::getModulesFilePath();

            // Check if "xlite_modules" table exists
            if (\Includes\Utils\FileManager::isFileReadable($path)) {

                // Set flag in .ini-file
                $pattern = '/(\[' . $data['author'] . '\][^\[]+\s*' . $data['name'] . '\s*=)\s*\S+/Ss';
                \Includes\Utils\FileManager::replace($path, '$1 1', $pattern);

            } else {

                // Set flag in DB.
                // This operation is highly NOT recommended in the usual workflow!
                // All info for this module must be stored before that!
                $query = 'UPDATE ' . static::getTableName() . ' SET enabled = ? WHERE moduleID = ?';
                \Includes\Utils\Database::execute($query, array(1, $data['moduleID']));

            }

            // Move the registry entry info into ENABLED registry to prevent LOST information
            static::moveModuleToEnabledRegistry($data['author'] . '\\' . $data['name']);

            // add to local cache
            static::$activeModules[$key] = $data;
        }
    }

    /**
     * Get disabled tables list storage path
     *
     * @return string
     */
    public static function getDisabledStructuresPath()
    {
        return LC_DIR_SERVICE . '.disabled.structures.php';
    }

    /**
     * Remove module information from the .disabled.structures file
     *
     * @param string $module Module actual name
     *
     * @return void
     */
    public static function removeModuleFromDisabledStructure($module)
    {
        $path = static::getDisabledStructuresPath();

        $data = \Includes\Utils\Operator::loadServiceYAML($path);

        unset($data[$module]);

        static::storeModuleRegistry($path, $data);
    }

    /**
     * Store DATA information in the YAML format to the file
     *
     * @param string     $path Path to the file
     * @param array|null $data Data to store in YAML
     *
     * @return void
     */
    public static function storeModuleRegistry($path, $data)
    {
        if ($data) {
            \Includes\Utils\Operator::saveServiceYAML($path, $data);

        } elseif (\Includes\Utils\FileManager::isExists($path)) {
            \Includes\Utils\FileManager::deleteFile($path);
        }
    }

    /**
     * Read modules migration log and return it as array of restoration points
     *
     * @return array|null
     */
    public static function readModuleMigrationLog()
    {
        $data = null;
        if (\Includes\Utils\FileManager::isFileReadable(static::getModuleMigrationLogFile())) {
            ob_start();
            $log = @include(static::getModuleMigrationLogFile());
            ob_get_clean();
            if (!empty($log) && is_array($log)) {
                $data = $log;
            }
        }
        return $data;
    }

    /**
     * Store current modules state for further restoration
     *
     * @param array|null     $restorePoint modules migration data
     *
     * @return void
     */
    public static function updateModuleMigrationLog($restorePoint)
    {
        $migrations = static::readModuleMigrationLog();
        if (empty($migrations)) {
            $migrations = array();
        }

        $migrations[$restorePoint["date"]] = $restorePoint;

        $serialized = "<?php\nreturn " . var_export($migrations, true) . ";";
        \Includes\Utils\FileManager::write(static::getModuleMigrationLogFile(), $serialized);
    }

    /**
     * Returns restore point from migration log if it exists
     *
     * @param string     $date restore point date in RESTORE_DATE_FORMAT format
     *
     * @return array
     */
    public static function getRestorePoint($date)
    {
        $restorePoint = null;
        $migrations = static::readModuleMigrationLog();
        if (!empty($migrations) && isset($migrations[$date]) && isset($migrations[$date]['current'])) {
            $restorePoint = $migrations[$date];
        } 
        return $restorePoint;
    }

    /**
     * Returns empty restore point structure to be filled later
     *
     * @return array
     */
    public static function getEmptyRestorePoint()
    {
        return array(
            'date' => date(static::RESTORE_DATE_FORMAT),
            'current' => array(),
            'enabled' => array(),
            'disabled' => array(),
            'deleted' => array(),
            'installed' => array()
        );
    }

    /**
     * Returns empty record about successful restoration
     *
     * @param string $restoredTo restore point date in RESTORE_DATE_FORMAT
     *
     * @return array
     */
    public static function getRestorationRecord($restoredTo)
    {
        return array(
            'date' => date(static::RESTORE_DATE_FORMAT),
            'restoredTo' => $restoredTo,
        );
    }

    /**
     * Store registry entry info of module into ENABLED registry
     *
     * @param string $module Module actual name
     * @param array  $data   Data to store
     *
     * @return void
     */
    public static function registerModuleToEnabledRegistry($module, $data)
    {
        $enabledPath = static::getEnabledStructurePath();

        $enabledRegistry          = \Includes\Utils\Operator::loadServiceYAML($enabledPath);
        $enabledRegistry[$module] = $data;

        static::storeModuleRegistry($enabledPath, $enabledRegistry);
    }

    /**
     * Move registry info entry from DISABLED registry to the ENABLED one.
     * Module must be set as ENABLED in the DB after this operation
     *
     * @param string $module Module actual name
     *
     * @return boolean Flag if the registry entry was moved
     */
    public static function moveModuleToEnabledRegistry($module)
    {
        $enabledPath     = static::getEnabledStructurePath();
        $enabledRegistry = \Includes\Utils\Operator::loadServiceYAML($enabledPath);

        $disabledPath     = static::getDisabledStructuresPath();
        $disabledRegistry = \Includes\Utils\Operator::loadServiceYAML($disabledPath);

        $result = false;

        if (isset($disabledRegistry[$module])) {

            $enabledRegistry[$module] = $disabledRegistry[$module];
            unset($disabledRegistry[$module]);

            $result = true;
        }

        static::storeModuleRegistry($enabledPath, $enabledRegistry);
        static::storeModuleRegistry($disabledPath, $disabledRegistry);

        return $result;
    }

    /**
     * Move registry info entry from ENABLED registry to the DISABLED one.
     * Module must be set as DISABLED in the DB after this operation
     *
     * @param string $module Module actual name
     *
     * @return boolean Flag if the registry entry was moved
     */
    public static function moveModuleToDisabledRegistry($module)
    {
        $enabledPath      = static::getEnabledStructurePath();
        $enabledRegistry  = \Includes\Utils\Operator::loadServiceYAML($enabledPath);

        $disabledPath     = static::getDisabledStructuresPath();
        $disabledRegistry = \Includes\Utils\Operator::loadServiceYAML($disabledPath);

        $result           = false;

        if (isset($enabledRegistry[$module])) {
            $disabledRegistry[$module] = $enabledRegistry[$module];
            unset($enabledRegistry[$module]);

            $result = true;
        }

        static::storeModuleRegistry($enabledPath, $enabledRegistry);
        static::storeModuleRegistry($disabledPath, $disabledRegistry);

        return $result;
    }

    /**
     * Get file with the modules DB structures registry file
     *
     * It has the same format as static::getDisabledStructuresPath() one
     *
     * @return string
     */
    public static function getEnabledStructurePath()
    {
        return LC_DIR_SERVICE . '.modules.structures.registry.php';
    }

    /**
     * Get file with the HASH of modules DB structures registry file
     *
     * @return string
     */
    public static function getEnabledStructureHashPath()
    {
        return LC_DIR_SERVICE . '.modules.structures.registry.hash.php';
    }

    /**
     * Get HASH of ENABLED registry structure
     *
     * @return string
     */
    public static function getEnabledStructureHash()
    {
        return \Includes\Utils\FileManager::read(static::getEnabledStructureHashPath());
    }

    /**
     * Save HASH of ENABLED registry structure to the specific file
     *
     * @param string $hash Hash
     *
     * @return boolean
     */
    public static function saveEnabledStructureHash($hash)
    {
        return \Includes\Utils\FileManager::write(static::getEnabledStructureHashPath(), $hash);
    }

    /**
     * Get structures to save when module is disabled
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return array
     */
    public static function getModuleProtectedStructures($author, $name)
    {
        $tables  = array();
        $columns = array();

        $path = static::getAbsoluteDir($author, $name) . 'Model';

        if (\Includes\Utils\FileManager::isExists($path)) {
            $filter = new \Includes\Utils\FileFilter($path, '/.*\.php$/Si');

            foreach ($filter->getIterator() as $path => $data) {

                // DO NOT call "getInterfaces()" after the "getFullClassName()"
                // DO NOT use reflection to get interfaces
                $interfaces = \Includes\Decorator\Utils\Tokenizer::getInterfaces($path);
                $class      = \Includes\Decorator\Utils\Tokenizer::getFullClassName($path);

                // Do 'autoload' checking first since the class_exists tries to use autoloader
                // but fails into "cannot include file" warning when model class is not set to use (LC_Dependencies issue)
                if (\Includes\Autoloader::checkAutoload($class) && class_exists($class)) {
                    // $reflectionClass = new \ReflectionClass($class);
                    if (
                        $class
                        && is_subclass_of($class, '\XLite\Model\AEntity')
                    ) {
                        $class = ltrim($class, '\\');
                        $len   = strlen(\Includes\Utils\Database::getTablesPrefix());

                        // DO NOT remove leading backslash in interface name
                        if (in_array('\XLite\Base\IDecorator', $interfaces)) {
                            $parent   = \Includes\Decorator\Utils\Tokenizer::getParentClassName($path);
                            $parent   = ltrim($parent, '\\');
                            $metadata = \XLite\Core\Database::getEM()->getClassMetadata($parent);
                            $table    = substr($metadata->getTableName(), $len);

                            $tool   = new \Doctrine\ORM\Tools\SchemaTool(\XLite\Core\Database::getEM());
                            $schema = $tool->getCreateSchemaSql(array($metadata));

                            foreach ((array) $metadata->reflFields as $field => $reflection) {
                                $pattern = '/(?:, |\()(' . $field . ' .+)(?:, [A-Za-z]|\) ENGINE)/USsi';

                                if (
                                    $reflection->class === $class
                                    && !empty($metadata->fieldMappings[$field])
                                    && preg_match($pattern, $schema[0], $matches)
                                ) {
                                    $columns[$table][$field] = $matches[1];
                                }
                            }

                            foreach ($metadata->associationMappings as $mapping) {

                                if ($metadata->reflFields[$mapping['fieldName']]->class === $class) {

                                    if (isset($mapping['joinTable']) && $mapping['joinTable']) {
                                        $tables[] = substr($mapping['joinTable']['name'], $len);

                                    } elseif (isset($mapping['joinColumns']) && $mapping['joinColumns']) {

                                        foreach ($mapping['joinColumns'] as $col) {

                                            $pattern = '/(?:, |\()(' . $col['name'] . ' .+)(?:, [A-Za-z]|\) ENGINE)/USsi';

                                            if (preg_match($pattern, $schema[0], $matches)) {
                                                $columns[$table][$col['name']] = $matches[1];
                                            }
                                        }
                                    }
                                }
                            }

                        } elseif (\XLite\Core\Database::getRepo($class)->canDisableTable()) {
                            $tables[] = substr(
                                \XLite\Core\Database::getEM()->getClassMetadata($class)->getTableName(), $len
                            );

                            $metadata = \XLite\Core\Database::getEM()->getClassMetadata($class);
                            foreach ($metadata->associationMappings as $mapping) {
                                if (isset($mapping['joinTable']) && $mapping['joinTable']) {
                                    $tables[] = substr($mapping['joinTable']['name'], $len);
                                }
                            }
                        }
                    }
                }
            }
        }

        return array(
            'tables' => $tables,
            'columns' => $columns
        );
    }

    /**
     * Get modules list file path
     *
     * @return string
     */
    protected static function getModulesFilePath()
    {
        return LC_DIR_VAR . static::MODULES_FILE_NAME;
    }

    /**
     * Check if modules list file exists
     *
     * @return boolean
     */
    public static function isModulesFileExists()
    {
        return \Includes\Utils\FileManager::isFileReadable(static::getModulesFilePath());
    }

    // }}}

    // {{{ DB-related routines

    /**
     * Fetch modules list from the database
     *
     * @return array
     */
    protected static function fetchModulesListFromDB()
    {
        $field = static::getModuleNameField();
        $table = static::getTableName();

        return static::checkTable('modules') ? \Includes\Utils\Database::fetchAll(
            'SELECT ' . $field . $table . '.* FROM ' . $table . ' WHERE installed = ?',
            array(1),
            \PDO::FETCH_ASSOC | \PDO::FETCH_GROUP | \PDO::FETCH_UNIQUE
        ) : array();
    }

    /**
     * Return name of the table where the module info is stored
     *
     * @return string
     */
    protected static function getTableName()
    {
        return get_db_tables_prefix() . 'modules';
    }

    /**
     * Part of SQL query to fetch composed module name
     *
     * @return string
     */
    protected static function getModuleNameField()
    {
        return 'CONCAT(author,\'\\\\\',name) AS actualName, ';
    }

    // {{{ List of all modules

    protected static $cachedModulesList;

    /**
     * Fetch list of active modules from DB
     *
     * @param boolean $reset Rest flag OPTIONAL
     *
     * @return array
     */
    protected static function getModulesList($reset = false)
    {
        if (!isset(static::$cachedModulesList) || $reset) {

            static::$cachedModulesList = array();
            $path = static::getModulesFilePath();
            if (\Includes\Utils\FileManager::isFileReadable($path)) {
                foreach (parse_ini_file($path, true) as $author => $data) {
                    foreach ($data as $name => $enabled) {
                        if ($enabled) {
                            static::$cachedModulesList[$author . '\\' . $name] = array(
                                'actualName' => static::getActualName($author, $name),
                                'name'       => $name,
                                'author'     => $author,
                                'enabled'    => $enabled,
                                'moduleName' => $name,
                                'authorName' => $author,
                                'yamlLoaded' => false,
                            );
                        }
                    }
                }

            } else {
                static::$cachedModulesList = static::fetchModulesListFromDB();
            }
        }

        return static::$cachedModulesList;
    }

    // }}}

    // {{{ Modules info manipulations

    /**
     * Remove file with active modules list
     *
     * @return void
     */
    public static function removeFile()
    {
        \Includes\Utils\FileManager::deleteFile(static::getModulesFilePath());
    }

    /**
     * Save modules to file
     *
     * @param array $modules Modules array
     *
     * @return void
     */
    public static function saveModulesToFile(array $modules)
    {
        $string = '';

        foreach ($modules as $author => $data) {
            $string .= '[' . $author . ']' . PHP_EOL;
            foreach ($data as $name => $enabled) {
                $string .= $name . ' = ' . ((bool) $enabled) . PHP_EOL;
            }
        }

        if ($string) {
            \Includes\Utils\FileManager::write(
                static::getModulesFilePath(),
                '; <' . '?php /*' . PHP_EOL . $string . '; */ ?' . '>'
            );
        }
    }

    /**
     * Write module info to DB
     *
     * @param string  $author              Module author
     * @param string  $name                Module name
     * @param boolean $isModulesFileExists Flag: true means that the installation process is going now OPTIONAL
     *
     * @return void
     */
    public static function switchModule($author, $name, $isModulesFileExists = false)
    {
        // Short names
        $condition = ' WHERE author = ? AND name = ?';
        $table     = static::getTableName();
        $module    = static::getActualName($author, $name);

        // Versions
        $majorVersion = static::callModuleMethod($module, 'getMajorVersion');
        $minorVersion = static::callModuleMethod($module, 'getMinorVersion');

        // Reset existing settings
        $query = 'UPDATE ' . $table . ' SET enabled = ?, installed = ?' . $condition;
        \Includes\Utils\Database::execute($query, array(0, 0, $author, $name));

        // Search for module
        $fields = array('moduleID');
        $condition .= ' AND fromMarketplace = ?';

        if (!$isModulesFileExists) {
            $fields[] = 'yamlLoaded';
        }

        $query = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $table . $condition . ' AND majorVersion = ? AND minorVersion = ?';

        $moduleRows = \Includes\Utils\Database::fetchAll(
            $query,
            array($author, $name, 0, $majorVersion, $minorVersion)
        );

        $needToLoadYaml = false;

        // If found in DB
        if ($moduleRows) {
            $moduleID = intval($moduleRows[0]['moduleID']);
            $yamlLoaded = intval($moduleRows[0]['yamlLoaded']);
            $moduleName   = static::callModuleMethod($module, 'getModuleName');            
            $moduleDesc   = static::callModuleMethod($module, 'getDescription');

            $params = array(
                'enabled = ?',
                'installed = ?',
                'moduleName = ?',
                'description = ?'
            );

            $data  = array(intval(static::isActiveModule($module)), 1, $moduleName, $moduleDesc, $moduleID,);

            if (!$yamlLoaded && static::isActiveModule($module)) {
                $params[] = 'yamlLoaded = ?';
                $data  = array(intval(static::isActiveModule($module)), 1, $moduleName, $moduleDesc, 1, $moduleID);
                $needToLoadYaml = true;
            }

            $query = 'UPDATE ' . $table . ' SET ' . implode(', ', $params) . ' WHERE moduleID = ?';

        } else {
            $data  = static::getModuleDataFromClass($author, $name);

            if ($data['enabled']) {
                $data['yamlLoaded'] = 1;
                $needToLoadYaml = true;
            }

            $query = 'REPLACE INTO ' . $table . ' SET ' . implode(' = ?,', array_keys($data)) . ' = ?';
        }

        if (static::isActiveModule($module) && $needToLoadYaml && !$isModulesFileExists) {
            static::addModuleYamlFile($author, $name);
        }

        // Save changes in DB
        \Includes\Utils\Database::execute($query, array_values($data));
    }

    /**
     * Add module's install.yaml file to the fixtures list file
     *
     * @param string $author Module author
     * @param string $name   Module name
     *
     * @return void
     */
    protected static function addModuleYamlFile($author, $name)
    {
        $dir = 'classes' . LC_DS
            . LC_NAMESPACE . LC_DS
            . 'Module' . LC_DS
            . $author . LC_DS
            . $name;

        $file = $dir . LC_DS . 'install.yaml';

        if (\Includes\Utils\FileManager::isFileReadable($file)) {
            \Includes\Decorator\Plugin\Doctrine\Utils\FixturesManager::addFixtureToList($file);
        }

        foreach ((array) glob($dir . LC_DS . 'install_*.yaml') as $translationFile) {
            if (\Includes\Utils\FileManager::isFileReadable($translationFile)) {
                \Includes\Decorator\Plugin\Doctrine\Utils\FixturesManager::addFixtureToList($translationFile);
            }
        }
    }

    // }}}

    // {{{ Module paths

    /**
     * Return pattern to check PHP file paths
     *
     * @return string
     */
    public static function getPathPatternForPHP()
    {
        $root = preg_quote(\Includes\Decorator\ADecorator::getClassesDir(), '/') . 'XLite';
        $modules = '(' . implode('|', static::getModuleQuotedPaths()) . ')';

        return '/^(?:'
            . $root . LC_DS_QUOTED . '((?!Module)[a-zA-Z0-9]+)' . LC_DS_QUOTED . '.+'
            . '|' . $root . LC_DS_QUOTED . 'Module' . LC_DS_QUOTED . $modules . LC_DS_QUOTED . '.+'
            . '|' . $root
            . '|' . $root . LC_DS_QUOTED . 'Module' . LC_DS_QUOTED . '[a-zA-Z0-9]+'
            . '|' . $root . LC_DS_QUOTED . '[a-zA-Z0-9]+'
            . ')\.php$/Ss';
    }

    /**
     * Return pattern to check .tpl file paths
     *
     * @return string
     */
    public static function getPathPatternForTemplates()
    {
        return static::getPathPattern(
            preg_quote(LC_DIR_SKINS, '/') . '\w+' . LC_DS_QUOTED . '\w+', 'modules', 'tpl'
        );
    }

    /**
     * Callback to collect module paths
     *
     * @param \Includes\Decorator\DataStructure\Graph\Modules $node Current module node
     *
     * @return void
     */
    public static function getModuleQuotedPathsCallback(\Includes\Decorator\DataStructure\Graph\Modules $node)
    {
        static::$quotedPaths[$node->getActualName()] = str_replace('\\', LC_DS_QUOTED, $node->getActualName());
    }

    /**
     * Return list of relative module paths
     *
     * @return array
     */
    protected static function getModuleQuotedPaths()
    {
        if (!isset(static::$quotedPaths)) {
            static::$quotedPaths = array();
            \Includes\Decorator\ADecorator::getModulesGraph()->walkThrough(
                array(get_called_class(), 'getModuleQuotedPathsCallback')
            );
        }

        return static::$quotedPaths;
    }

    /**
     * Return pattern to file path againist active modules list
     *
     * @param string $rootPath  Name of the root directory
     * @param string $dir       Name of the directory with modules
     * @param string $extension File extension
     *
     * @return string
     */
    protected static function getPathPattern($rootPath, $dir, $extension)
    {
        $modulePattern = $dir . LC_DS_QUOTED . ($placeholder = '@') . LC_DS_OPTIONAL;

        return '/^' . $rootPath . '(.((?!' . str_replace($placeholder, '\w+', $modulePattern) . ')|'
            . str_replace($placeholder, '(' . implode('|', static::getModuleQuotedPaths()) . ')', $modulePattern)
            . '))*\.' . $extension . '$/i';
    }

    // }}}
}
