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

namespace Includes\Decorator\Plugin\Doctrine\Plugin\QuickData;

/**
 * Main
 *
 */
class Main extends \Includes\Decorator\Plugin\Doctrine\Plugin\APlugin
{
    const STEP_TTL = 20;

    /**
     * Processing chunk length
     */
    const CHUNK_LENGTH = 100;

    public static function initializeCounter()
    {
        static::setCounter(0);
    }

    public static function setCounter($count)
    {
        $string = serialize(
            array('count' => $count)
        );
        \Includes\Utils\FileManager::write(
            static::getFilePath(),
            '; <' . '?php /*' . PHP_EOL . $string . '; */ ?' . '>'
        );
    }

    public static function getCounter()
    {
        $data = \Includes\Utils\FileManager::read(static::getFilePath());

        if ($data) {
            $data = substr($data, strlen('; <' . '?php /*' . PHP_EOL), strlen('; */ ?' . '>') * -1);
            $data = unserialize($data);
        }

        return ($data && is_array($data) && isset($data['count']))
            ? intval($data['count'])
            : 0;
    }

    /**
     * Check if quick data calculation allowed
     *
     * @return boolean
     */
    public static function isCalculateCacheAllowed()
    {
        $config = \XLite\Core\Config::getInstance()->CacheManagement;

        return $config && $config->quick_data_rebuilding;
    }

    /**
     * Get file path with fixtures paths
     *
     * @return string
     */
    protected static function getFilePath()
    {
        return LC_DIR_VAR . '.quickData.php';
    }

    /**
     * Execute certain hook handle
     *
     * @return void
     */
    public function executeHookHandler()
    {
        if (static::isCalculateCacheAllowed()
            && \Includes\Decorator\Utils\CacheInfo::get('rebuildBlockMark')
        ) {
            $i = static::getCounter();
            do {
                $processed = \XLite\Core\QuickData::getInstance()->updateChunk($i, static::CHUNK_LENGTH);
                if (0 < $processed) {
                    \XLite\Core\Database::getEM()->clear();
                }
                $i += $processed;
                static::setCounter($i);
                \Includes\Utils\Operator::showMessage('.', false, true);

            } while (0 < $processed && !\Includes\Decorator\Utils\CacheManager::isTimeExceeds(static::STEP_TTL));
        }
    }
}
