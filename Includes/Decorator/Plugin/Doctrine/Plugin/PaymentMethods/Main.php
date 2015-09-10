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

namespace Includes\Decorator\Plugin\Doctrine\Plugin\PaymentMethods;

/**
 * Main
 */
class Main extends \Includes\Decorator\Plugin\Doctrine\Plugin\APlugin
{
    
    /**
     * Methods list (local cache)
     * 
     * @var array
     */
    protected $list;

    /**
     * Check - current plugin is bocking or not
     *
     * @return boolean
     */
    public function isBlockingPlugin()
    {
        return parent::isBlockingPlugin()
            || $this->getChangedPaymentMethods();
    }

    /**
     * Execute certain hook handle
     *
     * @return void
     */
    public function executeHookHandler()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method');
        foreach ($this->getChangedPaymentMethods() as $row) {
            $row['method']->setModuleEnabled($row['state']);
            $repo->update($row['method']);
        }

        $this->list = null;
    }

    /**
     * Get changed payment methods 
     * 
     * @return array
     */
    protected function getChangedPaymentMethods()
    {
        if (!isset($this->list)) {
            $this->list = array();
            $repo = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method');
            foreach ($repo->iterateAll() as $method) {
                $method = $method[0];
                if ($method->getModuleName()) {
                    $isReallyModuleEnabled = (bool)$method->getProcessor();
                    if ($method->getModuleEnabled() != $isReallyModuleEnabled) {
                        $this->list[] = array(
                            'method' => $method,
                            'state'  => $isReallyModuleEnabled,
                        );
                    }
                }
            }
        }

        return $this->list;
    }
}
