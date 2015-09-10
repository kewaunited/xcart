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

namespace Includes\Decorator\Plugin\Templates\Plugin\Compiler;

/**
 * Main
 *
 */
class Main extends \Includes\Decorator\Plugin\Templates\Plugin\APlugin
{
    /**
     * Instance of the Flexy compiler
     *
     * @var \Xlite\Core\FlexyCompiler
     */
    protected $flexy;

    /**
     * Execute "postprocess" hook handler
     *
     * @return void
     */
    public function executeHookHandler()
    {
        if (!LC_DEVELOPER_MODE) {
            $this->createTemplatesCache();
        }
    }

    /**
     * Static templates compilation
     *
     * @return void
     */
    protected function createTemplatesCache()
    {
        $layout = \XLite\Core\Layout::getInstance();

        foreach ($this->getAnnotatedTemplates() as $data) {

            if (isset($data['zone'])) {
                switch ($data['zone']) {

                    case \XLite::ADMIN_INTERFACE:
                        $layout->setAdminSkin();
                        break;

                    case \XLite::CUSTOMER_INTERFACE:
                        $layout->setCustomerSkin();
                        break;

                    case \XLite::CONSOLE_INTERFACE:
                        $layout->setConsoleSkin();
                        break;

                    case \XLite::MAIL_INTERFACE:
                        $layout->setMailSkin();
                        break;

                    default:
                        break;
                }
            }

            \XLite\Singletons::$handler->flexy->prepare($data['path'], true);
        }
    }
}
