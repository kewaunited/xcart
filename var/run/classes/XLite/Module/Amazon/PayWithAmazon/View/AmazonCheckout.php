<?php
// vim: set ts=4 sw=4 sts=4 et:

namespace XLite\Module\Amazon\PayWithAmazon\View;

/**
 * Amazon checkout widget
 *
 * @ListChild (list="center", zone="customer")
 */
class AmazonCheckout extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('amazon_checkout'));
    }

   /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/Amazon/PayWithAmazon/checkout.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'checkout/steps/review/parts/items.js';

        return $list;
    }

    // compat with mailchimp module
    public function getProfile()
    {
        return \XLite::getController()->getCart()->getProfile();
    }

    /**
     * Get current refid
     *
     * @return string
     */
    public function getAmazonOrderRefId()
    {
        return \XLite\Core\Request::getInstance()->amz_pa_ref;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        if (!\XLite::isAdminZone() && method_exists('\XLite\Core\Request', 'isMobileDevice') && \XLite\Core\Request::isMobileDevice()) {
            return 'modules/Amazon/PayWithAmazon/checkout_mobile.tpl';
        } else {
            return 'modules/Amazon/PayWithAmazon/checkout.tpl';
        }
    }

}
