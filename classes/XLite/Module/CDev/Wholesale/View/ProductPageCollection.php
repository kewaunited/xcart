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

namespace XLite\Module\CDev\Wholesale\View;

/**
 * Product page widgets collection
 */
class ProductPageCollection extends \XLite\View\ProductPageCollection implements \XLite\Base\IDecorator
{
    /**
     * Register the view classes collection
     *
     * @return array
     */
    protected function defineWidgetsCollection()
    {
        return array_merge(
            parent::defineWidgetsCollection(),
            array(
                '\XLite\Module\CDev\Wholesale\View\ProductPrice',
            )
        );
    }

    /**
     * Check - allowed display subwidget or not
     *
     * @param string $name Widget class name
     *
     * @return boolean
     */
    protected function isAllowedWidget($name)
    {
        $result = parent::isAllowedWidget($name);

        if ($result) {
            switch ($name) {
                case '\XLite\Module\CDev\Wholesale\View\ProductPrice':
                    $types = $this->getProductModifierTypes();
                    if (empty($types['wholesalePrice'])) {
                        $result = false;
                    }
                    break;

                default:
            }
        }

        return $result;
    }

    /**
     * Get product modifier types
     *
     * @return array
     */
    protected function getProductModifierTypes()
    {
        $additional = null;
        $additionalVariants = null;
        $wholesale = null;

        if (!isset($this->productModifierTypes)) {
            if (\Includes\Utils\ModulesManager::isActiveModule('XC\ProductVariants')) {
                // ProductVariants module detected
                $additional = \XLite\Core\Database::getRepo('XLite\Module\XC\ProductVariants\Model\ProductVariant')
                    ->getModifierTypesByProduct($this->getProduct());
                $additionalVariants = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\ProductVariantWholesalePrice')
                    ->getModifierTypesByProduct($this->getProduct());
            }
            if ((!isset($additional) || empty($additional['price'])) && (!isset($additionalVariants) || empty($additionalVariants['price']))) {
                // ProductVariants module is not detected or product has not variants
                $wholesale = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')
                    ->getModifierTypesByProduct($this->getProduct());
            }
        }

        $result = parent::getProductModifierTypes();

        foreach (array($additional, $additionalVariants, $wholesale) as $modifierTypes) {

            if (isset($modifierTypes)) {
                $result += $modifierTypes;
                if (!$result['price'] && $modifierTypes['price']) {
                    $result['price'] = true;
                }

                $this->productModifierTypes = $result;
            }
        }

        return $result;
    }
}
