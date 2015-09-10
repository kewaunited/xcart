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

namespace XLite\Module\XC\AuctionInc\View\Model;

/**
 * TestRates widget
 */
class TestRates extends \XLite\View\Model\TestRates
{
    /**
     * Schema field names
     */
    const SCHEMA_FIELD_DIMENSIONS = 'dimensions';

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormTarget()
    {
        return 'auction_inc';
    }

    /**
     * Returns the list of related targets
     *
     * @return array
     */
    protected function getAvailableSchemaFields()
    {
        $result = array(
            static::SCHEMA_FIELD_WEIGHT,
            static::SCHEMA_FIELD_SUBTOTAL,
            static::SCHEMA_FIELD_DIMENSIONS,
            static::SCHEMA_FIELD_DST_COUNTRY,
            static::SCHEMA_FIELD_DST_STATE,
            static::SCHEMA_FIELD_DST_ZIPCODE,
            static::SCHEMA_FIELD_DST_TYPE,
        );

        if (!\XLite\Module\XC\AuctionInc\Main::isSSAvailable()) {
            $result = array_merge(
                $result,
                array(
                    static::SCHEMA_FIELD_SRC_COUNTRY,
                    static::SCHEMA_FIELD_SRC_STATE,
                    static::SCHEMA_FIELD_SRC_ZIPCODE,
                )
            );
        }

        return $result;
    }

    /**
     * Get the associative array of section fields where keys are separators of fields groups
     *
     * @return array
     */
    protected function getSchemaFieldsSubsections()
    {
        $result = parent::getSchemaFieldsSubsections();

        if (!isset($result[static::SCHEMA_FIELD_SEP_PACKAGE])) {
            $result[static::SCHEMA_FIELD_SEP_PACKAGE] = array();
        }

        $result[static::SCHEMA_FIELD_SEP_PACKAGE] = array_merge(
            $result[static::SCHEMA_FIELD_SEP_PACKAGE],
            array(
                static::SCHEMA_FIELD_DIMENSIONS,
            )
        );

        return $result;
    }

    /**
     * Get fields for schema
     *
     * @return array
     */
    protected function getTestRatesSchema()
    {
        $fields = array();
        foreach ($this->schemaTestRates as $fieldName => $field) {
            $fields[$fieldName] = $field;
            if ($fieldName == static::SCHEMA_FIELD_WEIGHT) {
                $fields[static::SCHEMA_FIELD_DIMENSIONS] = array(
                    self::SCHEMA_CLASS    => 'XLite\Module\XC\AuctionInc\View\FormField\Input\Dimensions',
                    self::SCHEMA_LABEL    => 'Dimensions',
                );
            }
        }
        $this->schemaTestRates = $fields;

        $this->schemaTestRates[static::SCHEMA_FIELD_SEP_SRC_ADDRESS][static::SCHEMA_LABEL] = 'Origin address';

        return parent::getTestRatesSchema();
    }
}
