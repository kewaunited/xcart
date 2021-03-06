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

namespace Includes\Decorator\Plugin\Doctrine\Utils;

/**
 * EntityManager 
 *
 */
abstract class EntityManager extends \Includes\Decorator\Plugin\Doctrine\ADoctrine
{
    /**
     * Entity manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $handler;

    /**
     * Model classes metadata
     *
     * @var array
     */
    protected static $metadata;

    /**
     * Return all classes metadata
     *
     * @param string $class Class name OPTIONAL
     *
     * @return array
     */
    public static function getAllMetadata($class = null)
    {
        if (!isset(static::$metadata)) {
            static::$metadata = array();

            // Create hash array to quick access its elements
            foreach (static::getHandler()->getMetadataFactory()->getAllMetadata() as $data) {
                static::$metadata[$data->name] = $data;
            }
        }

        return \Includes\Utils\ArrayManager::getIndex(static::$metadata, $class);
    }

    /**
     * Generate models
     *
     * @return void
     */
    public static function generateModels()
    {
        static::getEntityGenerator()->generate(
            static::getAllMetadata(),
            \Includes\Decorator\ADecorator::getCacheClassesDir()
        );
    }

    /**
     * Generate proxies
     *
     * @return void
     */
    public static function generateProxies()
    {
        static::getHandler()->getProxyFactory()->generateProxyClasses(
            static::getAllMetadata(),
            \Includes\Decorator\ADecorator::getCacheModelProxiesDir()
        );
    }

    /**
     * Retur DSN as params array
     *
     * @return array
     */
    protected static function getDSN()
    {
        return \Includes\Utils\Database::getConnectionParams(true) + array('driver' => 'pdo_mysql');
    }

    /**
     * Set metadata driver for Doctrine config
     * FIXME: to revise
     *
     * @param \Doctrine\ORM\Configuration $config Config object
     *
     * @return void
     */
    protected static function setMetadataDriver(\Doctrine\ORM\Configuration $config)
    {
        $chain = new \Doctrine\ORM\Mapping\Driver\DriverChain();
        $chain->addDriver(
            $config->newDefaultAnnotationDriver(static::getClassesDir() . 'XLite' . LC_DS . 'Model'),
            'XLite\Model'
        );

        $iterator = new \RecursiveDirectoryIterator(
            static::getClassesDir() . 'XLite' . LC_DS . 'Module',
            \FilesystemIterator::SKIP_DOTS
        );

        foreach ($iterator as $dir) {
            if (\Includes\Utils\FileManager::isDir($dir->getPathName())) {
                $iterator2 = new \RecursiveDirectoryIterator($dir->getPathName(), \FilesystemIterator::SKIP_DOTS);

                foreach ($iterator2 as $dir2) {
                    if (
                        \Includes\Utils\FileManager::isDir($dir2->getPathName())
                        && \Includes\Utils\FileManager::isDir($dir2->getPathName() . LC_DS . 'Model')
                    ) {
                        $chain->addDriver(
                            $config->newDefaultAnnotationDriver($dir2->getPathName() . LC_DS . 'Model'),
                            'XLite\Module\\' . $dir->getBaseName() . '\\' . $dir2->getBaseName() . '\Model'
                        );
                    }
                }
            }

        }

        $config->setMetadataDriverImpl($chain);
    }

    /**
     * Return the Doctrine config object
     *
     * @return \Doctrine\ORM\Configuration
     */
    protected static function getConfig()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setAutoGenerateProxyClasses(false);

        static::setMetadataDriver($config);

        // Set proxy settings
        $config->setProxyDir(rtrim(\Includes\Decorator\ADecorator::getCacheModelProxiesDir(), LC_DS));
        $config->setProxyNamespace(LC_MODEL_PROXY_NS);

        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        return $config;
    }

    /**
     * Return instance of the entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected static function getHandler()
    {
        if (!isset(static::$handler)) {
            static::$handler = \Doctrine\ORM\EntityManager::create(static::getDSN(), static::getConfig());
            \XLite\Core\Database::registerCustomTypes(static::$handler);
        }

        return static::$handler;
    }

    /**
     * Return the Doctrine tools
     *
     * @return \Doctrine\ORM\Tools\EntityGenerator
     */
    protected static function getEntityGenerator()
    {
        $generator = new \Includes\Decorator\Plugin\Doctrine\Utils\ModelGenerator();
        $generator->setGenerateAnnotations(true);
        $generator->setRegenerateEntityIfExists(false);
        $generator->setUpdateEntityIfExists(true);
        $generator->setGenerateStubMethods(true);
        $generator->setNumSpaces(4);
        $generator->setClassToExtend('\XLite\Model\AEntity');
        $generator->setBackupExisting(false);

        return $generator;
    }
}
