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

namespace XLite\Module\XC\ColorSchemes\View\FormField\Select;

/**
 * \XLite\View\FormField\Select\Template
 */
abstract class Template extends \XLite\View\FormField\Select\TemplateAbstract implements \XLite\Base\IDecorator
{
    /**
     * Check module is selected
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isModuleSelected($module)
    {
        $value = $this->getValue();

        if (static::SKIN_STANDARD === $module) {
            $result = (string) $this->getColorSchemesModuleId() === $value;

        } else {
            $result = $this->getModuleId($module) === $value;
        }

        return $result;
    }

    /**
     * Check if redeploy is required
     *
     * @param array|string $module Module
     *
     * @return string
     */
    protected function isRedeployRequired($module)
    {
        $value = $this->getValue();

        if ($module === static::SKIN_STANDARD
            || ($value === static::SKIN_STANDARD
                && isset($module['module'])
                && $module['module']->getModuleId() === $this->getColorSchemesModuleId()
            )
        ) {
            $result = false;

        } else {
            $result = parent::isRedeployRequired($module);
        }

        return $result;
    }

    /**
     * Returns ColorSchemes modules id
     *
     * @return integer
     */
    protected function getColorSchemesModuleId()
    {
        static $moduleId = null;

        if (null === $moduleId) {
            $module = \XLite\Core\Database::getRepo('XLite\Model\Module')
                ->findOneByModuleName('XC\ColorSchemes');

            $moduleId = $module->getModuleId();
        }

        return $moduleId;
    }
}
