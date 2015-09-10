<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View\FormField\Select;

/**
 * Sync mode selector
 */
class SyncMode extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'S' => static::t('Synchronous'),
            'A' => static::t('Asynchronous'),
        );
    }
}
