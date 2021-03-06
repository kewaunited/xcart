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

namespace XLite\Module\XC\ThemeTweaker\Controller\Admin;

/**
 * Custom CSS images controller
 */
class Images extends \XLite\Controller\Admin\Images implements \XLite\Base\IDecorator
{
    /**
     * Update action 
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        parent::doActionUpdate();

        $this->updateCustomImages();
    }

    /**
     * Update custom images
     *
     * @return void
     */
    protected function updateCustomImages()
    {
        $dir = \XLite\Module\XC\ThemeTweaker\Main::getThemeDir() . 'images' . LC_DS;

        if (
            $_FILES
            && $_FILES['new_images']
            && $_FILES['new_images']['name']
        ) {
            if (!\Includes\Utils\FileManager::isExists($dir)) {
                \Includes\Utils\FileManager::mkdirRecursive($dir);
            }

            if (\Includes\Utils\FileManager::isDirWriteable($dir)) {
                foreach ($_FILES['new_images']['name'] as $i => $data) {
                    \Includes\Utils\FileManager::moveUploadedFileByMultiple('new_images', $i, $dir);
                }

            } else {
                \XLite\Core\TopMessage::addError(
                    'The directory {{dir}} does not exist or is not writable.',
                    array(
                        'dir' => $dir
                    )
                );
            }
        }

        $delete = \XLite\Core\Request::getInstance()->delete;

        if (
            $delete
            && is_array($delete)
        ) {
            foreach ($delete as $file => $del) {
                if ($del) {
                    \Includes\Utils\FileManager::deleteFile($dir . $file);
                }
            }
        }
    }
}
