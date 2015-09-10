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

namespace XLite\Module\CDev\SimpleCMS\View\Model;

/**
 * Settings dialog model widget
 */
abstract class Settings extends \XLite\Module\CDev\Paypal\View\Model\Settings implements \XLite\Base\IDecorator
{
    /**
     * Logo & Favicon fields
     *
     * @var array
     */
    static protected $logoFaviconFields = array('logo', 'favicon');

    /**
     * Logo & Favicon validation flag
     *
     * @var boolean
     */
    protected $logoFaviconValidation = true;

    /**
     * Defines the subdirectory where images (logo, favicon) will be stored
     *
     * @return string
     */
    protected static function getLogoFaviconSubDir()
    {
        return \Includes\Utils\FileManager::getRelativePath(LC_DIR_IMAGES, LC_DIR) . LC_DS . 'simplecms' . LC_DS;
    }

    /**
     * Defines the server directory where images (logo, favicon) will be stored
     *
     * @return string
     */
    protected static function getLogoFaviconDir()
    {
        return LC_DIR . LC_DS . static::getLogoFaviconSubDir();
    }

    /**
     * Check for the form errors
     *
     * @return boolean
     */
    public function isValid()
    {
        return parent::isValid() && $this->logoFaviconValidation;
    }

    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        $options = $this->getEditableOptions();

        if ('logo_favicon' == $this->getTarget()) {
            foreach ($options as $k => $v) {
                if (in_array($v->name, static::$logoFaviconFields)) {
                    $data[$v->name] = $this->prepareImageData($v->value, $v->name);
                }
            }
        }

        parent::setModelProperties($data);
    }

    /**
     * Get schema fields
     *
     * @return array
     */
    public function getSchemaFields()
    {
        return $this->prepareOptions(parent::getSchemaFields());
    }

    /**
     * Get editable options
     *
     * @return array
     */
    protected function getEditableOptions()
    {
        return $this->prepareOptions(parent::getEditableOptions());
    }

    /**
     * Prepare options
     *
     * @param array $options Options
     *
     * @return array
     */
    protected function prepareOptions(array $options)
    {
        if (
            'logo_favicon' == $this->getTarget()
            || (
                'module' == $this->getTarget()
                && $this->getModule()
                && 'CDev\SimpleCMS' == $this->getModule()->getActualName()
            )
        ) {
            foreach ($options as $k => $v) {
                $id = is_object($v) && property_exists($v, 'name') ? $v->name : $k;
                if (
                    (
                        'logo_favicon' == $this->getTarget()
                        && !in_array($id, static::$logoFaviconFields)
                    )
                    || (
                        'logo_favicon' != $this->getTarget()
                        && in_array($id, static::$logoFaviconFields)
                    )
                ) {
                    unset($options[$k]);
                }
            }
        }

        return $options;
    }

    /**
     * Additional preparations for images.
     * Upload them into specific directory
     *
     * @param string $optionValue Option value
     * @param string $imageType   Image type
     *
     * @return string
     */
    protected function prepareImageData($optionValue, $imageType)
    {
        $dir = static::getLogoFaviconDir();
        if (
            $_FILES
            && $_FILES[$imageType]
            && $_FILES[$imageType]['name']
        ) {
            $path = null;

            $realName = preg_replace('/([^a-zA-Z0-9_\-\.]+)/', '_', $_FILES[$imageType]['name']);

            if ($this->isImage($_FILES[$imageType]['tmp_name'], $realName)) {

                if (!\Includes\Utils\FileManager::isDir($dir)) {
                    \Includes\Utils\FileManager::mkdirRecursive($dir);
                }

                if (\Includes\Utils\FileManager::isDir($dir)) {

                    // Remove file with same name as uploaded file in the destination directory
                    \Includes\Utils\FileManager::deleteFile(
                        $dir . LC_DS . ('favicon' === $imageType ? static::FAVICON : $realName)
                    );

                    // Move uploaded file to destination directory
                    $path = \Includes\Utils\FileManager::moveUploadedFile(
                        $imageType,
                        $dir,
                        'favicon' === $imageType ? static::FAVICON : $realName
                    );

                    if ($path) {
                        if ($optionValue && 'favicon' !== $imageType && basename($optionValue) != $realName) {
                            // Remove old image file
                            \Includes\Utils\FileManager::deleteFile($dir . basename($optionValue));
                        }
                        $optionValue = static::getLogoFaviconSubDir() . basename($path);
                    }
                }

                if (!isset($path)) {
                    $this->logoFaviconValidation = false;
                    \XLite\Core\TopMessage::addError(
                        'The "{{file}}" file was not uploaded',
                        array('file' => $realName)
                    );
                }

            } else {
                $this->logoFaviconValidation = false;
                \XLite\Core\TopMessage::addError(
                    'The "{{file}}" file is not allowed image and was not uploaded. Allowed images are: {{extensions}}',
                    array(
                        'file' => $realName,
                        'extensions' => implode(', ', $this->getImageExtensions()),
                    )
                );
            }

        } elseif (\XLite\Core\Request::getInstance()->useDefaultImage[$imageType]) {
            if ($optionValue) {
                \Includes\Utils\FileManager::deleteFile($dir . basename($optionValue));
            }
            $optionValue = '';
        }

        return $optionValue;
    }

    /**
     * Check if file is valid image
     *
     * @param string $path Temporary uploaded file path
     * @param string $name Real file name
     *
     * @return boolean
     */
    protected function isImage($path, $name)
    {
        return $this->hasImageName($name) && $this->isImageExtension($name) && $this->isImageMimeType($path);
    }

    /**
     * Return true if file has non-empty name
     *
     * @param string $path File path
     *
     * @return boolean
     */
    protected function hasImageName($path)
    {
        return 0 < strlen(trim(pathinfo($path, PATHINFO_FILENAME)));
    }

    /**
     * Return true if file has image extension
     *
     * @param string $path File path
     *
     * @return boolean
     */
    protected function isImageExtension($path)
    {
        return in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $this->getImageExtensions());
    }

    /**
     * Get list of allowed image extensions
     *
     * @return array
     */
    protected function getImageExtensions()
    {
        return array('gif', 'jpg', 'jpeg', 'png', 'ico');
    }

    /**
     * Return true if file has image mime type
     *
     * @param string $path File path
     *
     * @return boolean
     */
    protected function isImageMimeType($path)
    {
        $result = false;

        if (function_exists('exif_imagetype')) {
            $result = 0 < (int)@exif_imagetype($path);

        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $result = preg_match('/^image\/.*/', finfo_file($finfo, $path));
            finfo_close($finfo);

        } else {
            $data = @getimagesize($path);
            $result = is_array($data) && $data[0];
        }

        return $result;
    }
}
