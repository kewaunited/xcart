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
 * Region is a model for grouping states
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Region")
 * @Table (name="regions",
 *      uniqueConstraints={
 *          @UniqueConstraint (name="code", columns={"code","country_code"})
 *      },
 *      indexes={
 *          @Index (name="name", columns={"name"})
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class Region extends \XLite\Model\AEntity
{
    /**
     * Region code
     *
     * @var string
     * 
     * @Id
     * @Column (type="string", length=10)
     */
    protected $code;

    /**
     * Region name
     *
     * @var string
     *
     * @Column (type="string", length=64)
     */
    protected $name;

    /**
     * Region weight
     *
     * @var integer
     *
     * @Column (type="integer", nullable=true)
     */
    protected $weight;


    /**
     * Country (relation)
     *
     * @var \XLite\Model\Country
     *
     * @ManyToOne (targetEntity="XLite\Model\Country", inversedBy="regions", cascade={"merge","detach"})
     * @JoinColumn (name="country_code", referencedColumnName="code", onDelete="CASCADE")
     */
    protected $country;

    /**
     * States (relation)
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @OneToMany (targetEntity="XLite\Model\State", mappedBy="region", cascade={"all"})
     * @OrderBy   ({"state" = "ASC"})
     */
    protected $states;

    /**
     * Set code
     *
     * @param string $code
     * @return Region
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
     * Set name
     *
     * @param string $name
     * @return Region
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
     * Set weight
     *
     * @param integer $weight
     * @return Region
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set country
     *
     * @param XLite\Model\Country $country
     * @return Region
     */
    public function setCountry(\XLite\Model\Country $country = null)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return XLite\Model\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add states
     *
     * @param XLite\Model\State $states
     * @return Region
     */
    public function addStates(\XLite\Model\State $states)
    {
        $this->states[] = $states;
        return $this;
    }

    /**
     * Get states
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStates()
    {
        return $this->states;
    }
}