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

namespace Includes\Decorator\Plugin\Doctrine\Plugin\PrepareDBSchema;

/**
 * Main
 */
class Main extends \Includes\Decorator\Plugin\Doctrine\Plugin\APlugin
{
    /**
     * Execute certain hook handle
     *
     * @return void
     */
    public function executeHookHandler()
    {
        $this->saveMetadata();

        if (!\Includes\Decorator\Utils\CacheManager::isCapsular() || $this->isMetadataChanged()) {
            \Includes\Decorator\Utils\CacheInfo::set('metadataChangedState', true);
            \Includes\Decorator\Plugin\Doctrine\Utils\DBSchemaManager::prepareDBSchema();

        } else {
            \Includes\Decorator\Utils\CacheInfo::set('metadataChangedState', false);
            \Includes\Decorator\Plugin\Doctrine\Utils\DBSchemaManager::removeDBSchema();
        }
    }

    /**
     * Save current metadata 
     * 
     * @return void
     */
    protected function saveMetadata()
    {
        \Includes\Decorator\Utils\CacheInfo::set(
            'metadata',
            \Includes\Decorator\Plugin\Doctrine\Utils\EntityManager::getAllMetadata()
        );
    }

    /**
     * Check - metadata is changed or not
     * 
     * @return boolean
     */
    protected function isMetadataChanged()
    {
        $previous = \Includes\Decorator\Utils\CacheInfo::get('metadata', false);

        if (!$previous) {
            $result = true;

        } else {
            $currentHash = $this->getMetadataHash(\Includes\Decorator\Utils\CacheInfo::get('metadata'));
            $previousHash = $this->getMetadataHash($previous);

            \Includes\Decorator\Utils\CacheInfo::set(
                'metadataHashes',
                array(
                    'current'  => $currentHash,
                    'previous' => $previousHash,
                )
            );
            $result = $currentHash != $previousHash;
        }

        return $result;
    }

    /**
     * Get metadata hash 
     * 
     * @param array $metadatas Metadata list
     *  
     * @return string
     */
    protected function getMetadataHash(array $metadatas)
    {
        $hashs = array();
        foreach ($metadatas as $metadata) {
            $hashs[] = md5(serialize($metadata));
        }

        return md5(implode('', $hashs));
    }
}
