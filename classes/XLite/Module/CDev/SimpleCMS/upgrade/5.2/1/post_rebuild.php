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

return function()
{
    $data = \Includes\Utils\Operator::loadServiceYAML(
        LC_DIR_VAR . 'cleanURL.pages.yaml'
    );

    if ($data) {
        /** @var \XLite\Model\Repo\ARepo $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Page');
        $iterator = $repo->getExportIterator();
        $iterator->rewind();
        while ($iterator->valid()) {
            /** @var \XLite\Model\AEntity $entity */
            $entity = $iterator->current();
            $entity = $entity[0];

            if (!empty($data[$entity->getUniqueIdentifier()])) {

                $cleanURL = $data[$entity->getUniqueIdentifier()];

                $entity->setCleanUrl($cleanURL . '.htm', true);
                $entity->setCleanUrl($cleanURL . '.html', true);

                \XLite\Core\Database::getEM()->flush();
                \XLite\Core\Database::getEM()->clear();

                $entity->detach();
            }

            $iterator->next();
        }
    }
};
