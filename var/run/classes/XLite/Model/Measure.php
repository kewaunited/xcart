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
 * Measure
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Measure")
 * @Table  (name="measures")
 */
class Measure extends \XLite\Model\AEntity
{
    /**
     * Unique id
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Date (UNIX timestamp)
     *
     * @var integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $date;

    /**
     * File system test : time (msec.)
     *
     * @var integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $fsTime;

    /**
     * Database test : time (msec.)
     *
     * @var integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $dbTime;

    /**
     * Camputation test : time (msec.)
     *
     * @var integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $cpuTime;

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
     * Set date
     *
     * @param integer $date
     * @return Measure
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
     * Set fsTime
     *
     * @param integer $fsTime
     * @return Measure
     */
    public function setFsTime($fsTime)
    {
        $this->fsTime = $fsTime;
        return $this;
    }

    /**
     * Get fsTime
     *
     * @return integer 
     */
    public function getFsTime()
    {
        return $this->fsTime;
    }

    /**
     * Set dbTime
     *
     * @param integer $dbTime
     * @return Measure
     */
    public function setDbTime($dbTime)
    {
        $this->dbTime = $dbTime;
        return $this;
    }

    /**
     * Get dbTime
     *
     * @return integer 
     */
    public function getDbTime()
    {
        return $this->dbTime;
    }

    /**
     * Set cpuTime
     *
     * @param integer $cpuTime
     * @return Measure
     */
    public function setCpuTime($cpuTime)
    {
        $this->cpuTime = $cpuTime;
        return $this;
    }

    /**
     * Get cpuTime
     *
     * @return integer 
     */
    public function getCpuTime()
    {
        return $this->cpuTime;
    }
}