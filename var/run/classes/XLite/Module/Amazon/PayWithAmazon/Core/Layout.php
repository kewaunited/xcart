<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\Core;

/**
 * Layout
 */
abstract class Layout extends \XLite\Core\LayoutAbstract implements \XLite\Base\IDecorator
{
    /**
     * Define the pages where first sidebar will be hidden.
     *
     * @return array
     */
    protected function getSidebarFirstHiddenTargets()
    {
        return array_merge(
            parent::getSidebarFirstHiddenTargets(),
            array(
                'amazon_checkout',
            )
        );
    }
}
