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

return function()
{
    $paymentMethods = \XLite\Core\Database::getRepo('\XLite\Model\Payment\Method')->findBy(
        array('moduleName' => 'CDev_Moneybookers')
    );

    $order = array(
        'Moneybookers.WLT'   => '1010',
        'Moneybookers.ACC'   => '1020',
        'Moneybookers.VSA'   => '1030',
        'Moneybookers.MSC'   => '1040',
        'Moneybookers.VSD'   => '1050',
        'Moneybookers.VSE'   => '1060',
        'Moneybookers.MAE'   => '1070',
        'Moneybookers.SLO'   => '1080',
        'Moneybookers.AMX'   => '1090',
        'Moneybookers.DIN'   => '1100',
        'Moneybookers.JCB'   => '1110',
        'Moneybookers.LSR'   => '1120',
        'Moneybookers.GCB'   => '1130',
        'Moneybookers.DNK'   => '1140',
        'Moneybookers.PSP'   => '1150',
        'Moneybookers.CSI'   => '1160',
        'Moneybookers.OBT'   => '1170',
        'Moneybookers.GIR'   => '1180',
        'Moneybookers.DID'   => '1190',
        'Moneybookers.SFT'   => '1200',
        'Moneybookers.ENT'   => '1210',
        'Moneybookers.EBT'   => '1220',
        'Moneybookers.SO'    => '1230',
        'Moneybookers.IDL'   => '1240',
        'Moneybookers.NPY'   => '1250',
        'Moneybookers.PLI'   => '1260',
        'Moneybookers.PWY'   => '1270',
        'Moneybookers.PWY5'  => '1280',
        'Moneybookers.PWY6'  => '1290',
        'Moneybookers.PWY7'  => '1300',
        'Moneybookers.PWY14' => '1310',
        'Moneybookers.PWY15' => '1320',
        'Moneybookers.PWY17' => '1330',
        'Moneybookers.PWY18' => '1340',
        'Moneybookers.PWY19' => '1350',
        'Moneybookers.PWY20' => '1360',
        'Moneybookers.PWY21' => '1370',
        'Moneybookers.PWY22' => '1380',
        'Moneybookers.PWY25' => '1390',
        'Moneybookers.PWY26' => '1400',
        'Moneybookers.PWY28' => '1410',
        'Moneybookers.PWY32' => '1420',
        'Moneybookers.PWY33' => '1430',
        'Moneybookers.PWY36' => '1440',
        'Moneybookers.EPY'   => '1450',
    );

    /** @var \XLite\Model\Payment\Method $paymentMethod */
    foreach ($paymentMethods as $paymentMethod) {
        $paymentMethod->setOrderBy($order[$paymentMethod->getServiceName()]);
    }

    \XLite\Core\Database::getEM()->flush();
};
