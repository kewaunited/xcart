<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\FormField\Input;

/**
 * Seller ID field with registration link
 */
class SellerID extends \XLite\View\FormField\Input\Text
{
    protected function getFieldTemplate()
    {
        return '../modules/Amazon/PayWithAmazon/sellerid.tpl';
    }
}
