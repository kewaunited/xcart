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

namespace XLite\Core\Lock;

define('LC_DIR_LOCKS', LC_DIR_DATACACHE . LC_DS . 'locks' . LC_DS);
/**
 * File lock
 */
class FileLock extends \XLite\Base\Singleton implements \XLite\Core\Lock\ILock
{
    /**
     * Lock files directory
     */
    const LOCK_DIR      = LC_DIR_LOCKS;
    const FILE_SUFFIX   = '.lock';

    /**
     * Default time to live in seconds (one day)
     */
    const DEFAULT_TTL = 86400;

    /**
     * Constructor
     * Creates directory for locks if needed
     */
    public function __construct()
    {
        if (!\Includes\Utils\FileManager::isExists(rtrim(static::LOCK_DIR, LC_DS))) {
            \Includes\Utils\FileManager::mkdirRecursive(rtrim(static::LOCK_DIR, LC_DS));
        }
        if (
            !\Includes\Utils\FileManager::isReadable(static::LOCK_DIR)
            || !\Includes\Utils\FileManager::isWriteable(static::LOCK_DIR)
        ) {
            \XLite\Logger::getInstance()->log(
                'Cannot create lock for keys',
                LOG_DEBUG
            );
        }
        parent::__construct();
    }

    /**
     * Get filename by provided key
     * 
     * @param string    $key    Lock identifier
     * 
     * @return string Filename
     */
    protected function getFileName($key)
    {
        return static::LOCK_DIR . $key . static::FILE_SUFFIX;
    }

    /**
     * Check if provided key should be removed
     * 
     * @param string    $filename   Filename of lock
     * @param integer   $ttl        Time to live in seconds
     */
    protected function isExpired($filename, $ttl)
    {
        clearstatcache();
        $lastModified = @filemtime($filename);

        $expirationTime = file_get_contents($filename);

        if ( empty($expirationTime) ) {
            $realTtl = $ttl ?: static::DEFAULT_TTL;
            $expirationTime = $lastModified + $realTtl;
        }

        return null !== $lastModified
            && time() > $expirationTime;
    }

    /**
     * Check if provided key is not released
     * 
     * @param string    $key        Lock identifier
     * @param boolean   $strict     Do not check for expiration
     * @param integer   $ttl        Time to live in seconds OPTIONAL
     * 
     * @return boolean
     */
    public function isRunning($key, $strict = false, $ttl = null) {
        $result = false;
        $filename = $this->getFileName($key);
        if (
            file_exists($filename)
            && ($strict || !$this->isExpired($filename, $ttl))
        ) {
            $result = true;
        } else {
            $this->release($key);
        }

        return $result;
    }

    /**
     * Mark provided key as running
     * Puts time of key expiring
     * 
     * @param string    $key    Lock identifier
     * @param integer   $ttl    Time to live in seconds OPTIONAL
     * 
     * @return void
     */
    public function setRunning($key, $ttl = null) {
        $content = null === $ttl
            ? ''
            : time() + $ttl;
        file_put_contents(
            $this->getFileName($key),
            $content
        );
    }

    /**
     * Mark provided key as released
     * 
     * @param string $key Lock identifier
     * 
     * @return void
     */
    public function release($key) {
        $filename = $this->getFileName($key);
        if (file_exists($filename)) {
            unlink($this->getFileName($key));
        }
    }
}
