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

namespace XLite\Module\XC\News\Model;

/**
 * NewsMessage
 *
 * @Entity (repositoryClass="\XLite\Module\XC\News\Model\Repo\NewsMessage")
 * @Table  (name="news",
 *      indexes={
 *          @Index (name="enabled", columns={"enabled"}),
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class NewsMessage extends \XLite\Model\Base\Catalog
{
    /**
     * Unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Is menu enabled or not
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $enabled = true;

    /**
     * Date add news message
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $date;

    /**
     * Clean URLs
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\CleanURL", mappedBy="newsMessage", cascade={"all"})
     * @OrderBy   ({"id" = "ASC"})
     */
    protected $cleanURLs;

    /**
     * Meta description type
     *
     * @var string
     *
     * @Column (type="string", length=1)
     */
    protected $metaDescType = 'A';

    /**
     * Prepare order before save data operation
     *
     * @return void
     *
     * @PrePersist
     * @PreUpdate
     */
    public function prepareBeforeSave()
    {
        parent::prepareBeforeSave();

        if (!is_numeric($this->date) || !is_int($this->date)) {
            $this->setDate(\XLite\Core\Converter::time());
        }
    }

    /**
     * Check - news is enabled or not
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getEnabled()
            && $this->getDate() < \XLite\Core\Converter::time();
    }

    /**
     * Get front URL
     *
     * @return string
     */
    public function getFrontURL()
    {
        $url = null;
        if ($this->getId()) {
            $url = \XLite\Core\Converter::makeURLValid(
                \XLite::getInstance()->getShopURL(
                    \XLite\Core\Converter::buildURL(
                        'newsMessage',
                        '',
                        array('id' => $this->getId()),
                        \XLite::CART_SELF,
                        true
                    )
                )
            );
        }

        return $url;
    }

    /**
     * Returns meta description
     *
     * @return string
     */
    public function getMetaDesc()
    {
        return 'A' === $this->getMetaDescType()
            ? strip_tags($this->getBody())
            : $this->getSoftTranslation()->getMetaDesc();
    }

    /**
     * Returns meta description type
     *
     * @return string
     */
    public function getMetaDescType()
    {
        $result = $this->metaDescType;

        if (!$result) {
            $metaDescPresent = array_reduce($this->getTranslations()->toArray(), function ($carry, $item) {
                return $carry ?: (bool) $item->getMetaDesc();
            }, false);

            $result = $metaDescPresent ? 'C' : 'A';
        }

        return $result;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return NewsMessage
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set date
     *
     * @param integer $date
     * @return NewsMessage
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set metaDescType
     *
     * @param string $metaDescType
     * @return NewsMessage
     */
    public function setMetaDescType($metaDescType)
    {
        $this->metaDescType = $metaDescType;
        return $this;
    }

    /**
     * Add cleanURLs
     *
     * @param XLite\Model\CleanURL $cleanURLs
     * @return NewsMessage
     */
    public function addCleanURLs(\XLite\Model\CleanURL $cleanURLs)
    {
        $this->cleanURLs[] = $cleanURLs;
        return $this;
    }

    /**
     * Get cleanURLs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCleanURLs()
    {
        return $this->cleanURLs;
    }

    /**
     * Translations (relation). AUTOGENERATED
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @OneToMany (targetEntity="XLite\Module\XC\News\Model\NewsMessageTranslation", mappedBy="owner", cascade={"all"})
     */
    protected $translations;

    /**
     * Translation getter. AUTOGENERATED
     *
     * @return string
     */
    public function getName()
    {
        return $this->getSoftTranslation()->getName();
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setName($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setName($value);
    }

    /**
     * Translation getter. AUTOGENERATED
     *
     * @return string
     */
    public function getBody()
    {
        return $this->getSoftTranslation()->getBody();
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setBody($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setBody($value);
    }

    /**
     * Translation getter. AUTOGENERATED
     *
     * @return string
     */
    public function getBriefDescription()
    {
        return $this->getSoftTranslation()->getBriefDescription();
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setBriefDescription($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setBriefDescription($value);
    }

    /**
     * Translation getter. AUTOGENERATED
     *
     * @return string
     */
    public function getMetaTags()
    {
        return $this->getSoftTranslation()->getMetaTags();
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setMetaTags($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setMetaTags($value);
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setMetaDesc($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setMetaDesc($value);
    }

    /**
     * Translation getter. AUTOGENERATED
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->getSoftTranslation()->getMetaTitle();
    }

    /**
     * Translation setter. AUTOGENERATED
     *
     * @param string $value value to set
     *
     * @return void
     */
    public function setMetaTitle($value)
    {
        $translation = $this->getTranslation();

        if (!$this->hasTranslation($translation->getCode())) {
            $this->addTranslations($translation);
        }

        return $translation->setMetaTitle($value);
    }


}