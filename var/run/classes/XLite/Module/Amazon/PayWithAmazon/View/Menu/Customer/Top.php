<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\Menu\Customer;

/**
 * Hide top selector for amazon checkout
 */
abstract class Top extends \XLite\View\Menu\Customer\TopAbstract implements \XLite\Base\IDecorator
{

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        if (\XLite\Core\Request::getInstance()->target == 'amazon_checkout') {
            return false;
        } else {
            return parent::isVisible();
        }
    }

}
