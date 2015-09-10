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

namespace XLite\View;

/**
 * Shipping estimator
 *
 * @ListChild (list="center")
 */
class ShippingEstimate extends \XLite\View\AView
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();

        $result[] = 'shipping_estimate';

        return $result;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'shopping_cart/shipping_estimator/body.tpl';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getModifier();
    }

    /**
     * Get countries list
     *
     * @return array(\XLite\Model\Country)
     */
    protected function getCountries()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Country')
            ->findByEnabled(true);
    }

    /**
     * Return true if state selector field is visible
     *
     * @return boolean
     */
    protected function isStateFieldVisible()
    {
        return $this->checkStateFieldVisibility();
    }

    /**
     * Return true if custom_state input field is visible
     *
     * @return boolean
     */
    protected function isCustomStateFieldVisible()
    {
        return $this->checkStateFieldVisibility(true);
    }

    /**
     * Common method to check visibility of state fields
     *
     * @param boolean $isCustom Flag: true - check for custom_state field visibility, false - state selector field
     *
     * @return boolean
     */
    protected function checkStateFieldVisibility($isCustom = false)
    {
        $result = false;

        // hasField() method is defined in controller XLite\Controller\Customer\ShippingEstimate
        if ($this->hasField('state_id')) {

            if ($this->hasField('country_code')) {
                $result = true;

            } else {

                $address = $this->getAddress();

                $countryCode = !empty($address['country'])
                    ? $address['country']
                    : \XLite\Core\Config::getInstance()->Shipping->anonymous_country;

                $country = \XLite\Core\Database::getRepo('XLite\Model\Country')->findOneByCode($countryCode);

                $result = $isCustom
                    ? !$country || !$country->hasStates()
                    : $country && $country->hasStates();
            }
        }

        return $result;
    }

    /**
     * Get selected country code
     *
     * @return string
     */
    protected function getCountryCode()
    {
        $address = $this->getAddress();

        $c = 'US';

        if ($address && isset($address['country'])) {
            $c = $address['country'];

        } elseif (\XLite\Core\Config::getInstance()->Shipping->anonymous_country) {
            $c = \XLite\Core\Config::getInstance()->Shipping->anonymous_country;
        }

        return $c;
    }

    /**
     * Get state
     *
     * @return \XLite\Model\State
     */
    protected function getState()
    {
        $address = $this->getAddress();

        $state = null;

        // From getDestinationAddress()
        if ($address && isset($address['state']) && $address['state']) {
            $state = \XLite\Core\Database::getRepo('XLite\Model\State')->find($address['state']);

        } elseif (
            $this->getCart()->getProfile()
            && $this->getCart()->getProfile()->getShippingAddress()
            && $this->getCart()->getProfile()->getShippingAddress()->getState()
        ) {

            // From shipping address
            $state = $this->getCart()->getProfile()->getShippingAddress()->getState();

        } elseif (
            !$address
            && \XLite\Core\Config::getInstance()->Shipping->anonymous_custom_state
        ) {

            // From config
            $state = new \XLite\Model\State();
            $state->setState(\XLite\Core\Config::getInstance()->Shipping->anonymous_custom_state);

        }

        return $state;
    }

    /**
     * Get state
     *
     * @return \XLite\Model\State
     */
    protected function getOtherState()
    {
        $state = null;

        $address = $this->getAddress();

        if (isset($address) && isset($address['custom_state'])) {
            $state = $address['custom_state'];

        } elseif (
            $this->getCart()->getProfile()
            && $this->getCart()->getProfile()->getShippingAddress()
            && $this->getCart()->getProfile()->getShippingAddress()->getiCustomState()
        ) {
            // From shipping address
            $state = $this->getCart()->getProfile()->getShippingAddress()->getCustomState();
        }

        return $state;
    }

    /**
     * Get ZIP code
     *
     * @return string
     */
    protected function getZipcode()
    {
        $address = $this->getAddress();

        return ($address && isset($address['zipcode']))
            ? $address['zipcode']
            : '';
    }

    /**
     * Get address type code
     *
     * @return string
     */
    protected function getType()
    {
        $address = $this->getAddress();

        return ($address && isset($address['type']))
            ? $address['type']
            : '';
    }

    /**
     * Check - shipping is estimate or not
     *
     * @return boolean
     */
    protected function isEstimate()
    {
        return $this->getAddress()
            && $this->getCart()->getProfile()
            && $this->getCart()->getProfile()->getShippingAddress();
    }

}
