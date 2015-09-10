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

namespace XLite\Model;

/**
 * Notification translations
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Base\Translation")
 * @Table (name="notification_translations",
 *      indexes={
 *          @Index (name="ci", columns={"code","id"}),
 *          @Index (name="id", columns={"id"})
 *      }
 * )
 */
class NotificationTranslation extends \XLite\Model\Base\Translation
{
    /**
     * Notification name
     *
     * @var string
     *
     * @Column (type="string", length=128)
     */
    protected $name = '';

    /**
     * Notification description
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $description = '';

    /**
     * Notification subject for customer
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $customerSubject = '';

    /**
     * Notification text for customer
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $customerText = '';

    /**
     * Notification subject for admin
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $adminSubject = '';

    /**
     * Notification text for admin
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $adminText = '';

    /**
     * Set name
     *
     * @param string $name
     * @return NotificationTranslation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     * @return NotificationTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set customerSubject
     *
     * @param string $customerSubject
     * @return NotificationTranslation
     */
    public function setCustomerSubject($customerSubject)
    {
        $this->customerSubject = $customerSubject;
        return $this;
    }

    /**
     * Get customerSubject
     *
     * @return string 
     */
    public function getCustomerSubject()
    {
        return $this->customerSubject;
    }

    /**
     * Set customerText
     *
     * @param text $customerText
     * @return NotificationTranslation
     */
    public function setCustomerText($customerText)
    {
        $this->customerText = $customerText;
        return $this;
    }

    /**
     * Get customerText
     *
     * @return text 
     */
    public function getCustomerText()
    {
        return $this->customerText;
    }

    /**
     * Set adminSubject
     *
     * @param string $adminSubject
     * @return NotificationTranslation
     */
    public function setAdminSubject($adminSubject)
    {
        $this->adminSubject = $adminSubject;
        return $this;
    }

    /**
     * Get adminSubject
     *
     * @return string 
     */
    public function getAdminSubject()
    {
        return $this->adminSubject;
    }

    /**
     * Set adminText
     *
     * @param text $adminText
     * @return NotificationTranslation
     */
    public function setAdminText($adminText)
    {
        $this->adminText = $adminText;
        return $this;
    }

    /**
     * Get adminText
     *
     * @return text 
     */
    public function getAdminText()
    {
        return $this->adminText;
    }

    /**
     * Get label_id
     *
     * @return integer 
     */
    public function getLabelId()
    {
        return $this->label_id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return NotificationTranslation
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Translation owner (relation). AUTOGENERATED
     *
     * @var XLite\Model\Notification
     *
     * @ManyToOne  (targetEntity="XLite\Model\Notification", inversedBy="translations")
     * @JoinColumn (name="id", referencedColumnName="templatesDirectory", onDelete="CASCADE")
     */
    protected $owner;


}