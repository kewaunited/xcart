<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\FormField\Select;

/**
 * Currency selector
 */
class Currency extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'USD' => 'United States (USD)',
            'GBP' => 'United Kingdom (GBP)',
            'EUR' => 'Germany (EUR)',
        );
    }
}
