<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View;

class Content extends \XLite\View\Content implements \XLite\Base\IDecorator
{
    /**
     * Check - first sidebar is visible or not
     *
     * @return boolean
     */
    protected function isSidebarFirstVisible()
    {
        if (\XLite\Core\Request::getInstance()->target == 'amazon_checkout') {
            return false;
        } else {
            return parent::isSidebarFirstVisible();
        }
    }
}

