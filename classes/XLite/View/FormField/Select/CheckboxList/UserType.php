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

namespace XLite\View\FormField\Select\CheckboxList;

/**
 * User type selector
 */
class UserType extends \XLite\View\FormField\Select\CheckboxList\ACheckboxList
{
    /**
     * Get user types
     *
     * @return array
     */
    protected function getUserTypes()
    {
        $types = array(
            'C' => static::t('Registered Customers'),
            'N' => static::t('Anonymous Customers'),
        );

        if (\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins')) {
            $types['A'] = static::t('Administrator');
        }            
        return $types;
    }

    /**
     * Get roles
     *
     * @return array
     */
    protected function getRoles()
    {
        $list = array();

        foreach (\XLite\Core\Database::getRepo('XLite\Model\Role')->findAll() as $role) {
            $list[$role->getId()] = $role->getPublicName();
        }

        return $list;
    }

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = array();

        $list['C'] = array(
            'label' => static::t('Customer'),
            'options' => array(),
        );

        foreach ($this->getUserTypes() as $userType => $label) {
            if ('A' == $userType) {
                $list[$userType] = array(
                    'label' => $label,
                    'options' => $this->getRoles(),
                );
            } else {
                $list['C']['options'][$userType] = $label;
            }
        }

        ksort($list);

        return $list;
    }

    /**
     * Set common attributes
     *
     * @param array $attrs Field attributes to prepare
     *
     * @return array
     */
    protected function setCommonAttributes(array $attrs)
    {
        $list = parent::setCommonAttributes($attrs);
        $list['data-placeholder'] = static::t('All user types');

        return $list;
    }

}
