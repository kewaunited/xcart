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

namespace XLite\View\Button;

/**
 * Activate license key popup button
 */
class ActivateKey extends \XLite\View\Button\APopupButton
{
    /**
     * Widget params
     */
    const PARAM_IS_MODULE = 'isModule';

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/activate_key.js';

        return $list;
    }

    /**
     * Register CSS files
     * TODO: should be loaded in popup; remove after loading will be fixed
     * 
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules_manager/activate_key/css/style.css';

        return $list;
    }

    /**
     * Return content for popup button
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Activate your X-Cart';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_IS_MODULE => new \XLite\Model\WidgetParam\Int('Is module activation', 0),
        );
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        $params = array(
            'target' => 'activate_key',
            'action' => 'view',
            'widget' => '\XLite\View\ModulesManager\LicenseKey',
            'returnUrl' => \XLite\Core\URLManager::getCurrentURL(),
        );

        if ($this->isModuleActivation()) {
            $params['isModule'] = true;
        }

        return $params;
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' activate-key';
    }

    /**
     * Check if module activation
     *
     * @return boolean
     */
    protected function isModuleActivation()
    {
        return $this->getParam(static::PARAM_IS_MODULE);
    }

    /**
     * Button is visible only if license has been activated
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && !\XLite::getXCNLicense();
    }
}
