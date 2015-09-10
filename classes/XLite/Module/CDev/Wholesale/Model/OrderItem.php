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

namespace XLite\Module\CDev\Wholesale\Model;

/**
 * Order item
 */
class OrderItem extends \XLite\Model\OrderItem implements \XLite\Base\IDecorator
{
    /**
     * Get price
     *
     * @return float
     */
    public function getClearPrice()
    {
        $this->setWholesaleValues();

        return parent::getClearPrice();
    }

    /**
     * Check if item has a wrong amount
     *
     * @return boolean
     */
    public function hasWrongAmount()
    {
        $minQuantity = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\MinQuantity')
            ->getMinQuantity(
                $this->getProduct(),
                $this->getOrder()->getProfile() ? $this->getOrder()->getProfile()->getMembership() : null
            );

        $minimumQuantity = $minQuantity ? $minQuantity->getQuantity() : 1;

        return parent::hasWrongAmount() || ($minimumQuantity > $this->getAmount());
    }

    /**
     * Check - item price is controlled by server or not
     *
     * @return boolean
     */
    public function isPriceControlledServer()
    {
        $result = parent::isPriceControlledServer();

        if (!$result && $this->getProduct()) {
            $model = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')
                ->findOneBy(array('product' => $this->getProduct()));
            $result = !!$model;
        }

        return $result;
    }

    /**
     * Set wholesale values
     *
     * @return void
     */
    public function setWholesaleValues()
    {
        $this->getProduct()->setWholesaleQuantity($this->getAmount());
        if ($this->getOrder() && $this->getOrder()->getProfile()) {
            $this->getProduct()->setWholesaleMembership(
                $this->getOrder()->getProfile()->getMembership() ?: false
            );
        }
    }
}
