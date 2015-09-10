<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\FormField\Select;

/**
 * Capture mode selector
 */
class CaptureMode extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'A' => static::t('Authorization then capture'),
            'C' => static::t('Immediate Charge'),
        );
    }
}
