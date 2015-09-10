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

namespace XLite\View\FormField\Select\Model;

/**
 * Profile selector widget
 */
class ProfileSelector extends \XLite\View\FormField\Select\Model\Selector
{
    /**
     * Defines the JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'form_field/model_selector/profile/controller.js';

        return $list;
    }

    /**
     * Defines the model specific JS-namespace event
     *
     * @return string
     */
    protected function getDataType()
    {
        return 'profile';
    }

    /**
     * Defines the text phrase if no models are found
     *
     * @return string
     */
    protected function getDefaultEmptyPhrase()
    {
        return static::t('No profiles found');
    }

    /**
     * Defines the text if no model is selected
     *
     * @return string
     */
    protected function getDefaultEmptyModelDefinition()
    {
        return static::t('Profile is not selected');
    }

    /**
     * Defines the URL to request the models
     *
     * @return string
     */
    protected function getDefaultGetter()
    {
        return $this->buildURL('model_profile_selector');
    }

    /**
     * Defines the text value of the model
     *
     * @return string
     */
    protected function getTextValue()
    {
        $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($this->getValue());

        return $profile ? ($profile->getName() .  ' &lt;' . $profile->getLogin() . '&gt;') : '';
    }

    /**
     * Defines the name of the text value input
     *
     * @return string
     */
    protected function getTextName()
    {
        return $this->getParam(static::PARAM_NAME) . '_text';
    }
}
