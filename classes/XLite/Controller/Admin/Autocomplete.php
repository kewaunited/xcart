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

namespace XLite\Controller\Admin;

/**
 * Autocomplete controller 
 */
class Autocomplete extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Data 
     * 
     * @var array
     */
    protected $data = array();

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $result = parent::checkACL();

        if (!$result) {
            $dictionary = \XLite\Core\Request::getInstance()->dictionary;

            $permissions = $this->getDictionaryPermissions();

            if (!empty($permissions[$dictionary])) {
                foreach ($permissions[$dictionary] as $p) {
                    if (\XLite\Core\Auth::getInstance()->isPermissionAllowed($p)) {
                        $result = true;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Process request
     *
     * @return void
     */
    public function processRequest()
    {
        $content = json_encode($this->data);

        header('Content-Type: application/json; charset=UTF-8');
        header('Content-Length: ' . strlen($content));
        header('ETag: ' . md5($content));

        print ($content);
    }

    /**
     * Get list of possible dictionary permissions
     *
     * @return array
     */
    protected function getDictionaryPermissions()
    {
        return array(
            'attributeOption' => array(
                'manage catalog',
            ),
        );
    }

    /**
     * Preprocessor for no-action run
     *
     * @return void
     */
    protected function doNoAction()
    {
        $dictionary = \XLite\Core\Request::getInstance()->dictionary;

        if ($dictionary) {
            $method = 'assembleDictionary' . \XLite\Core\Converter::convertToCamelCase($dictionary);
            if (method_exists($this, $method)) {

                // Method name assmbled from 'assembleDictionary' + dictionary input argument
                $data = $this->$method(strval(\XLite\Core\Request::getInstance()->term));
                $this->data = $this->processData($data);
            }
        }

        $this->silent = true;
    }

    /**
     * Process data 
     * 
     * @param array $data Key-value data
     *  
     * @return array
     */
    protected function processData(array $data)
    {
        $list = array();

        foreach ($data as $k => $v) {
            $list[] = array(
                'label' => $v,
                'value' => $k,
            );
        }

        return $list;
    }

    /**
     * Assemble dictionary - conversation recipient
     *
     * @param string $term Term
     *
     * @return array
     */
    protected function assembleDictionaryAttributeOption($term)
    {
        $cnd = new \XLite\Core\CommonCell;
        if ($term) {
            $cnd->{\XLite\Model\Repo\AttributeOption::SEARCH_NAME} = $term;
        }

        $id = intval(\XLite\Core\Request::getInstance()->id);
        if ($id) {
            $cnd->{\XLite\Model\Repo\AttributeOption::SEARCH_ATTRIBUTE} = $id;
        }

        $list = array();

        foreach (\XLite\Core\Database::getRepo('\XLite\Model\AttributeOption')->search($cnd) as $a) {
            $list[$a->getName()] = $a->getName();
        }

        return $list;
    }

}
