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

namespace XLite\View;

/**
 * 'Powered by' widget
 *
 * @ListChild (list="sidebar.footer", zone="customer")
 */
class PoweredBy extends \XLite\View\AView
{
    /**
     * Phrase to use in footer
     */
    const PHRASE = '[shopping cart software]';

    /**
     * Advertise phrases
     *
     * @var array
     */
    protected $phrases = array(
        'en' => array(
            '[Powered by X-Cart shopping cart]',
            '[Powered by X-Cart shopping cart]',
            '[Powered by X-Cart shopping cart software]',
            '[Powered by X-Cart shopping cart software]',
            '[Powered by X-Cart PHP shopping cart]',
            '[Powered by X-Cart PHP shopping cart system]',
            '[Powered by X-Cart eCommerce shopping cart]',
            '[Powered by X-Cart online shopping cart]',
            '[Powered by X-Cart online shopping cart]',
            '[Powered by X-Cart eCommerce software]',
            '[Powered by X-Cart eCommerce software]',
            '[Powered by X-Cart e-commerce software]',
            '[Powered by X-Cart e-commerce software]',
            '[Powered by X-Cart eCommerce solution]',
            '[Powered by X-Cart eCommerce solution]',
            '[Powered by X-Cart e-commerce solution]',
            '[Powered by X-Cart e-commerce solution]',
            '[Powered by X-Cart free shopping cart]',
            '[Powered by X-Cart free shopping cart]',
            '[Powered by X-Cart online shop software]',
            '[Powered by X-Cart online shop software]',
            '[Powered by X-Cart open source eCommerce platform]',
            '[Powered by X-Cart open source eCommerce platform]',
        ),
        'ru' => array(
            '[Интернет магазин X-Cart]',
            '[Создан на базе интернет магазина X-Cart]',
            '[PHP интернет магазин X-Cart]',
            '[X-Cart - бесплатный интернет магазин]',
            '[X-Cart - интернет магазин с открытым кодом]',
        ),
    );

    /**
     * Site urls
     *
     * @var array
     */
    protected $siteURLs = array(
        'ru' => 'http://www.x-cart.ru',
    );

    /**
     * Check - display widget as link or as box
     *
     * @return boolean
     */
    public function isLink()
    {
        return \XLite\Core\Request::getInstance()->target == \XLite::TARGET_DEFAULT;
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'powered_by.css';

        return $list;
    }

    /**
     * Return a Powered By message
     *
     * @return string
     */
    public function getMessage()
    {
        $installationLng = \XLite::getInstallationLng();
        $siteURL = $installationLng && isset($this->siteURLs[$installationLng])
            ? $this->siteURLs[$installationLng]
            : '';

        $replace = $this->isLink()
                 ? array('[' => '<a href="' . \XLite::getXCartURL($siteURL, empty($siteURL)) . '" target="_blank">', ']' => '</a>',)
                 : array('[' => '', ']' => '');

        return strtr($this->getPhrase(), $replace);
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'powered_by.tpl';
    }

    /**
     * Get a Powered By phrase
     *
     * @return string
     */
    protected function getPhrase()
    {
        $phrase = static::PHRASE;

        $installationLng = \XLite::getInstallationLng();
        $currentPhrases = $installationLng && isset($this->phrases[$installationLng])
            ? $this->phrases[$installationLng]
            : $this->phrases['en'];

        if (isset($currentPhrases)
            && is_array($currentPhrases)
            && 0 < count($currentPhrases)
        ) {
            if (!isset(\XLite\Core\Config::getInstance()->Internal->prnotice_index)
                || !isset($currentPhrases[\XLite\Core\Config::getInstance()->Internal->prnotice_index])
            ) {
                $index = mt_rand(0, count($currentPhrases) - 1);

                \XLite\Core\Database::getRepo('\XLite\Model\Config')->createOption(
                    array(
                        'category' => 'Internal',
                        'name'     => 'prnotice_index',
                        'value'    => $index
                    )
                );

            } else {
                $index = intval(\XLite\Core\Config::getInstance()->Internal->prnotice_index);
            }

            $tmp = $currentPhrases[$index];

            if (is_string($tmp)
                && 0 < strlen(trim($tmp))
            ) {
                $phrase = $tmp;
            }
        }

        return $phrase;
    }

    /**
     * Get company year
     *
     * @return string
     */
    protected function getCompanyYear()
    {
        $currentYear = intval(\XLite\Core\Converter::formatDate(\XLite\Core\Converter::time(), '%Y'));
        $startYear = \XLite::isAdminZone() ? 2002 : intval(\XLite\Core\Config::getInstance()->Company->start_year);

        return $startYear && $startYear < $currentYear
            ? $startYear . ' - ' . $currentYear
            : $currentYear;
    }
}
