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
 
 namespace XLite\Module\CDev\XPaymentsConnector\View\Tabs;

/**
 * Profile dialog
 */
class AdminProfile extends \XLite\View\Tabs\AdminProfile implements \XLite\Base\IDecorator
{
    /**
     * Define and set handler attributes; initialize handler
     *
     * @param array $params Handler params OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = array())
    {
        $cnd = new \XLite\Core\CommonCell();
        $cnd->class = 'Module\CDev\XPaymentsConnector\Model\Payment\Processor\SavedCard';

        $saveCardsMethods = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->search($cnd);

        if ($saveCardsMethods) {
            $found = false;
            foreach ($saveCardsMethods as $pm) {
                if ($pm->isEnabled()) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                $this->tabs['saved_cards'] = array(
                    'title'    => 'Saved credit cards',
                    'template' => 'modules/CDev/XPaymentsConnector/account/saved_cards.tpl',
                );
            }
        }

        parent::__construct();
    }
}
