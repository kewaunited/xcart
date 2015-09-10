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

namespace XLite\View\Menu\Admin;

/**
 * Top-right side drop down links
 *
 * @ListChild (list="admin.main.page.header.right", weight="200", zone="admin")
 */
class TopLinks extends \XLite\View\Menu\Admin\AAdmin
{

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/style.less';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/controller.js';

        return $list;
    }

    /**
     * Define items
     *
     * @return array
     */
    protected function defineLanguageSelectorItems()
    {
        $items = array();

        $activeLanguages = $this->getActiveLanguages();

        if ($activeLanguages && count($activeLanguages) > 1) {
            $currentLanguage = $this->getCurrentLanguage();

            $items = array(
                'lng_selector' => array(
                    static::ITEM_TITLE      => strtoupper($currentLanguage->getCode()),
                    static::ITEM_WEIGHT     => 50,
                    static::ITEM_CHILDREN   => array(),
                ),
            );

            $weight = 1;
            foreach ($activeLanguages as $lng) {
                $items['lng_selector'][static::ITEM_CHILDREN][$lng->getCode()] = array(
                    static::ITEM_TITLE      => strtoupper($lng->getCode()),
                    static::ITEM_LINK       => $this->getChangeLanguageLink($lng),
                    static::ITEM_WEIGHT     => $weight++,
                    static::ITEM_ICON_IMG   => \XLite\Core\Layout::getInstance()->getResourceWebPath(
                        $lng->getFlagFile(),
                        null,
                        \XLite\Core\Layout::PATH_COMMON
                    ),
                    static::ITEM_PUBLIC_ACCESS => true,
                );
            }
        }

        return $items;
    }

    /**
     * Get link to change language
     *
     * @param \XLite\Model\Language $language Language object
     *
     * @return string
     */
    protected function getChangeLanguageLink(\XLite\Model\Language $language)
    {
        return $this->buildURL(
            $this->getTarget(),
            'change_language',
            array(
                'language' => $language->getCode(),
            ) + $this->getAllParams(),
            false
        );
    }

    /**
     * Define items
     *
     * @return array
     */
    protected function defineItems()
    {
        return $this->defineLanguageSelectorItems() + array(
            'help' => array(
                static::ITEM_TITLE      => $this->getSVGImage('images/fa-question-circle.svg'),
                static::ITEM_WEIGHT     => 100,
                static::ITEM_CHILDREN   => array(
                    'knoweledge_base' => array(
                        static::ITEM_TITLE      => static::t('Knowledge Base'),
                        static::ITEM_LINK       => 'http://kb.x-cart.com/',
                        static::ITEM_WEIGHT     => 100,
                        static::ITEM_BLANK_PAGE => true,
                    ),
                    'developers_docs' => array(
                        static::ITEM_TITLE      => static::t('Developers docs'),
                        static::ITEM_LINK       => 'http://kb.x-cart.com/pages/viewpage.action?pageId=7077893',
                        static::ITEM_WEIGHT     => 200,
                        static::ITEM_BLANK_PAGE => true,
                    ),
                    'suggest_idea' => array(
                        static::ITEM_TITLE      => static::t('Suggest an idea'),
                        static::ITEM_LINK       => 'http://ideas.x-cart.com/forums/229428-x-cart-5-ideas',
                        static::ITEM_WEIGHT     => 300,
                        static::ITEM_BLANK_PAGE => true,
                    ),
                    'report_bug' => array(
                        static::ITEM_TITLE      => static::t('Report a bug'),
                        static::ITEM_LINK       => 'http://bt.x-cart.com/',
                        static::ITEM_WEIGHT     => 400,
                        static::ITEM_ICON_SVG   => 'images/bug.svg',
                        static::ITEM_BLANK_PAGE => true,
                    ),
                ),
            ),
            'account' => array(
                static::ITEM_TITLE      => $this->getSVGImage('images/fa-male-user.svg'),
                static::ITEM_WEIGHT     => 100000,
                static::ITEM_CLASS      => 'account',
                static::ITEM_CHILDREN   => array(
                    'account_info' => array(
                        static::ITEM_TITLE         => \XLite\Core\Auth::getInstance()->getProfile()->getLogin(),
                        static::ITEM_CLASS         => 'text',
                        static::ITEM_WEIGHT        => 100,
                        static::ITEM_PUBLIC_ACCESS => true,
                    ),
                    'profile' => array(
                        static::ITEM_TITLE         => static::t('Profile settings'),
                        static::ITEM_TARGET        => 'profile',
                        static::ITEM_WEIGHT        => 200,
                        static::ITEM_PUBLIC_ACCESS => true,
                    ),
                    'logoff' => array(
                        static::ITEM_TITLE         => static::t('Sign out'),
                        static::ITEM_CLASS         => 'logoff',
                        static::ITEM_TARGET        => 'login',
                        static::ITEM_EXTRA         => array('action' => 'logoff'),
                        static::ITEM_WEIGHT        => 100000,
                        static::ITEM_PUBLIC_ACCESS => true,
                    ),
                ),
            ),
        );
    }

    /**
     * Return widget directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'top_links';
    }

    /**
     * Get default widget
     *
     * @return string
     */
    protected function getDefaultWidget()
    {
        return 'XLite\View\Menu\Admin\TopLinks\Node';
    }

    /**
     * Get active languages
     *
     * @return array
     */
    protected function getActiveLanguages()
    {
        $list = array();

        foreach (\XLite\Core\Database::getRepo('\XLite\Model\Language')->findActiveLanguages() as $language) {
            $list[] = $language;
        }

        return $list;
    }
}
