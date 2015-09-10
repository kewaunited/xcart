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
 * Membership selector
 */
class MembershipSearch extends \XLite\View\FormField\Select\CheckboxList\ACheckboxList
{
    const TYPE_MEMBERSHIP = 'M';
    const TYPE_PENDING    = 'P';
    /**
     * Memberships cache
     *
     * @var array
     */
    protected $memberships = null;

    /**
     * Get memberships
     *
     * @param string $type Type of owning of membership
     *
     * @return array
     */
    protected function getMemberships($type)
    {
        if (!isset($this->memberships)) {
            $this->memberships = \XLite\Core\Database::getRepo('XLite\Model\Membership')->findAll();
        }

        return array_reduce(
            $this->memberships,
            function ($carry, $item) use ($type) {
                $key = $type . '_' . $item->getMembershipId();
                $carry[$key] = $item->getName();

                return $carry;
            },
            array()
        );
    }

    /**
     * Returns types of owning of membership
     *
     * @return array
     */
    protected function getMembershipTypes()
    {
        return array(
            static::TYPE_MEMBERSHIP => static::t('Memberships'),
            static::TYPE_PENDING    => static::t('Pending memberships'),
        );
    }

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = array();

        foreach ($this->getMembershipTypes() as $type => $label) {
            $list[$type] = array(
                'label' => $label,
                'options' => $this->getMemberships($type),
            );
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
        $list['data-placeholder'] = static::t('All memberships');

        return $list;
    }
}
