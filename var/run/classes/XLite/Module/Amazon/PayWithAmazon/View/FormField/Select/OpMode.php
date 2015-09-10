<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\FormField\Select;

/**
 * Mode selector
 */
class OpMode extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'live' => static::t('Live'),
            'test' => static::t('Test'),
        );
    }
}
