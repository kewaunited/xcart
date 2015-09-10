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

namespace XLite\Module\CDev\Paypal\Model;

/**
 * \XLite\Module\CDev\SocialLogin\Model\Profile
 * @MappedSuperClass
 */
abstract class Profile extends \XLite\Model\ProfileAbstract implements \XLite\Base\IDecorator
{
    /**
     * Auth provider (paypal)
     *
     * @var string
     *
     * @Column (type="string", length=128, nullable=true)
     */
    protected $socialLoginProvider;

    /**
     * Auth provider-unique user id (for ex. facebook user id)
     *
     * @var string
     *
     * @Column (type="string", length=128, nullable=true)
     */
    protected $socialLoginId;

    /**
     * Checks if current profile is a SocialLogin's profile
     *
     * @return boolean
     */
    public function isSocialProfile()
    {
        return (bool) $this->getSocialLoginProvider();
    }

    /**
     * Set socialLoginProvider
     *
     * @param string $socialLoginProvider
     * @return Profile
     */
    public function setSocialLoginProvider($socialLoginProvider)
    {
        $this->socialLoginProvider = $socialLoginProvider;
        return $this;
    }

    /**
     * Get socialLoginProvider
     *
     * @return string 
     */
    public function getSocialLoginProvider()
    {
        return $this->socialLoginProvider;
    }

    /**
     * Set socialLoginId
     *
     * @param string $socialLoginId
     * @return Profile
     */
    public function setSocialLoginId($socialLoginId)
    {
        $this->socialLoginId = $socialLoginId;
        return $this;
    }

    /**
     * Get socialLoginId
     *
     * @return string 
     */
    public function getSocialLoginId()
    {
        return $this->socialLoginId;
    }
}