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
 * Core
 */
class Core extends \XLite\Upgrade\Entry\AEntry
{
    /**
     * Core major version
     *
     * @var string
     */
    protected $majorVersion;

    /**
     * Core minor version
     *
     * @var string
     */
    protected $minorVersion;

    /**
     * Core revision date
     *
     * @var integer
     */
    protected $revisionDate;

    /**
     * Pack size (in bytes)
     *
     * @var integer
     */
    protected $size;

    /**
     * Return entry readable name
     *
     * @return string
     */
    public function getName()
    {
        return 'Core';
    }

    /**
     * Return icon URL
     *
     * @return string
     */
    public function getIconURL()
    {
        return 'skins/admin/en/images/core_image.png';
    }

    /**
     * Return entry old major version
     *
     * @return string
     */
    public function getMajorVersionOld()
    {
        return \XLite::getInstance()->getMajorVersion();
    }

    /**
     * Return entry old minor version
     *
     * @return string
     */
    public function getMinorVersionOld()
    {
        return \XLite::getInstance()->getMinorVersion();
    }

    /**
     * Return entry new major version
     *
     * @return string
     */
    public function getMajorVersionNew()
    {
        return $this->majorVersion;
    }

    /**
     * Return entry new minor version
     *
     * @return string
     */
    public function getMinorVersionNew()
    {
        return $this->minorVersion;
    }

    /**
     * Return entry revision date
     *
     * @return integer
     */
    public function getRevisionDate()
    {
        return $this->revisionDate;
    }

    /**
     * Return module author readable name
     *
     * @return string
     */
    public function getAuthor()
    {
        return 'X-Cart team';
    }

    /**
     * Check if module is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * Check if module is installed
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return true;
    }

    /**
     * Return entry pack size
     *
     * @return integer
     */
    public function getPackSize()
    {
        return $this->size;
    }

    /**
     * Return module actual name
     *
     * @return string
     */
    public function getActualName()
    {
        return $this->getName();
    }

    /**
     * Check if module is skin
     *
     * @return boolean
     */
    public function isSkinModule()
    {
        return false;
    }

    /**
     * Download hashes for current version
     *
     * @return array
     */
    protected function loadHashesForInstalledFiles()
    {
        return \XLite\Core\Marketplace::getInstance()->getCoreHash(
            $this->getMajorVersionOld(),
            $this->getMinorVersionOld()
        );
    }

    /**
     * Constructor
     *
     * @param string  $majorVersion Core major version
     * @param string  $minorVersion Core minor version
     * @param integer $revisionDate Core revison date
     * @param integer $size         Pack size
     *
     * @return void
     */
    public function __construct($majorVersion, $minorVersion, $revisionDate, $size)
    {
        if (!$this->checkMajorVersion($majorVersion) || !$this->checkMinorVersion($majorVersion, $minorVersion)) {
            $version = \Includes\Utils\Converter::composeVersion($majorVersion, $minorVersion);
            \Includes\ErrorHandler::fireError('Unallowed core version for upgrade: ' . $version);
        }

        if ($revisionDate >= \XLite\Core\Converter::time()) {
            \Includes\ErrorHandler::fireError('Invalid core revision date: "' . date(DATE_RFC822, $revisionDate) . '"');
        }

        $this->majorVersion = $majorVersion;
        $this->minorVersion = $minorVersion;
        $this->revisionDate = $revisionDate;
        $this->size         = $size;

        parent::__construct();
    }

    /**
     * Names of variables to serialize
     *
     * @return array
     */
    public function __sleep()
    {
        $list = parent::__sleep();
        $list[] = 'majorVersion';
        $list[] = 'minorVersion';
        $list[] = 'revisionDate';
        $list[] = 'size';

        return $list;
    }

    /**
     * Download package
     *
     * @return boolean
     */
    public function download()
    {
        $result = false;

        $majorVersion = $this->getMajorVersionNew();
        $minorVersion = $this->getMinorVersionNew();

        $path   = \XLite\Core\Marketplace::getInstance()->getCorePack($majorVersion, $minorVersion);
        $params = array('major' => $majorVersion, 'minor' => $minorVersion);

        if (isset($path)) {
            $this->addFileInfoMessage('Core pack (v.{{major}}.{{minor}}) is received', $path, true, $params);

            $this->setRepositoryPath($path);
            $this->saveHashesForInstalledFiles();

            $result = parent::download();

        } else {
            $this->addFileErrorMessage('Core pack (v.{{major}}.{{minor}}) is not received', \XLite\Core\Marketplace::getInstance()->getError(), true, $params);
        }

        return $result;
    }

    /**
     * Return path where the upgrade helper scripts are placed
     *
     * @return string
     */
    protected function getUpgradeHelperPath()
    {
        return '';
    }

    /**
     * Get yaml file name to run common helper 'add_labels'
     *
     * @return string
     */
    protected function getCommonHelperAddLabelsFiles()
    {
        $result = array();

        $files = array(
            LC_DIR_ROOT . 'sql' . LC_DS . 'xlite_data.yaml',
            LC_DIR_ROOT . 'sql' . LC_DS . 'xlite_data_lng.yaml',
        );

        foreach ($files as $file) {
            if (\Includes\Utils\FileManager::isExists($file)) {
                $result[] = $file;
            }
        }

        return $result;
    }

    /**
     * Check if version is allowed
     *
     * @param string $majorVersion Version to check
     *
     * @return boolean
     */
    protected function checkMajorVersion($majorVersion)
    {
        return \XLite::getInstance()->checkVersion($majorVersion, '<=');
    }

    /**
     * Check if version is allowed
     *
     * @param string $majorVersion Version to check
     * @param string $minorVersion Version to check
     *
     * @return boolean
     */
    protected function checkMinorVersion($majorVersion, $minorVersion)
    {
        return \XLite::getInstance()->checkVersion($majorVersion, '<')
            || version_compare(\XLite::getInstance()->getMinorVersion(), $minorVersion, '<');
    }
}
