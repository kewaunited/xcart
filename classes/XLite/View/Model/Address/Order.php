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

namespace XLite\View\Model\Address;

/**
 * Order's profile model widget
 */
class Order extends \XLite\View\Model\Address\Address
{

    /**
     * Widget parameter names
     */
    const PARAM_ADDRESS_TYPE = 'addressType';

    /**
     * Return current address ID
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->getParam(static::PARAM_ADDRESS_TYPE);
    }

    /**
     * Get address ID from request
     *
     * @return integer
     */
    public function getRequestAddressId()
    {
        $request = \XLite\Core\Request::getInstance();

        return 'shipping' == $this->getParam(static::PARAM_ADDRESS_TYPE)
            ? $request->shippingAddress['id']
            : $request->billingAddress['id'];
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
            static::PARAM_ADDRESS_TYPE => new \XLite\Model\WidgetParam\String('Address type', ''),
        );
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Address
     */
    protected function getDefaultModelObject()
    {
        if (!isset($this->address)) {
            if ($this->getRequestAddressId()) {
                $this->address = \XLite\Core\Database::getRepo('XLite\Model\Address')->find($this->getRequestAddressId());

            } else {
                $profile = $this->getOrder()->getProfile();
                if ('shipping' == $this->getParam(static::PARAM_ADDRESS_TYPE)) {
                    $this->address = $profile->getShippingAddress() ?: $profile->getBillingAddress();

                } else {
                    $this->address = $profile->getBillingAddress() ?: $profile->getShippingAddress();
                }
            }
        }

        return $this->address;
    }

    /**
     * Retrieve property from the model object
     *
     * @param string $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        $prefix = $this->getParam(static::PARAM_ADDRESS_TYPE) . 'Address';

        if (\XLite\Core\Request::getInstance()->$prefix) {
            $data = \XLite\Core\Request::getInstance()->$prefix;
            $pureName = preg_replace('/^([^_]*_)(.*)$/', '\2', $name);
            $value = isset($data[$pureName]) ? $data[$pureName] : parent::getModelObjectValue($name);

        } else {
            $value = parent::getModelObjectValue($name);
        }

        return $value;

    }

}
