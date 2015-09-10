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

namespace XLite\View\FormField\Select;

/**
 * Upgrade wave selector
 */
class UpgradeWave extends \XLite\View\FormField\Select\Regular
{
    /**
     * Waves list
     *
     * @var array
     */
    protected static $waves = null;

    /**
     * Get current wave value
     *
     * @return string
     */
    public function getValue()
    {
        $value = parent::getValue();

        $waves = $this->getWaves();

        if ($waves) {
            if (empty($value) || (!isset($waves[$value]) && !is_numeric($value))) {
                $waveKeys = array_keys($waves);
                $value = array_pop($waveKeys);
            }
        }

        return $value;
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = $this->getWaves();
        $value = $this->getValue();

        if (!isset($options[$value])) {
            $options = array_merge(
                array($value => static::t('Tester')),
                $options
            );
        }

        return $options;
    }

    /**
     * Get list of upgrade waves
     *
     * @return array
     */
    protected function getWaves()
    {
        if (!isset(static::$waves)) {
            static::$waves = \XLite\Core\Marketplace::getInstance()->getWaves();
        }

        return static::$waves;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return $this->getWaves() && !$this->isDefaultFreeLicenseActivated()
            ? 'select_upgrade_wave.tpl'
            : 'label.tpl';
    }

    /**
     * Return true if default free license key is activated
     *
     * @return boolean
     */
    protected function isDefaultFreeLicenseActivated()
    {
        return \XLite\Core\Marketplace::XC_FREE_LICENSE_KEY == \XLite::getXCNLicenseKey();
    }

    /**
     * Get label value
     *
     * @return string
     */
    protected function getLabelValue()
    {
        return $this->isDefaultFreeLicenseActivated()
            ? static::t('Upgrade access level cannot be changed for default free license')
            : static::t('There are no activated license keys');
    }

    /**
     * Get help message for tooltip
     *
     * @return string
     */
    protected function getHelpMessage()
    {
        return static::t('Upgrade access level tooltip message');
    }
}
