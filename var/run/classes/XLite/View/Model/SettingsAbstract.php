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

namespace XLite\View\Model;

/**
 * Settings dialog model widget
 */
abstract class SettingsAbstract extends \XLite\View\Model\AModel
{
    /**
     * Row index delta (for calculation of odd/even CSS classes for field rows)
     *
     * @var integer
     */
    protected $rowIndexDelta = 0;


    /**
     * Get a list of JS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'settings/summary/controller.js';

        return $list;
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'settings/summary/summary.css';

        return $list;
    }

    /**
     * Get schema fields
     *
     * @return array
     */
    public function getSchemaFields()
    {
        $list = array();

        foreach ($this->getOptions() as $option) {
            $cell = $this->getFormFieldByOption($option);
            if ($cell) {
                $list[$option->getName()] = $cell;
            }
        }

        return $list;
    }

    /**
     * Get form field by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return array
     */
    protected function getFormFieldByOption(\XLite\Model\Config $option)
    {
        $cell = null;

        $class = $this->detectFormFieldClassByOption($option);

        if ($class) {
            $cell = array(
                self::SCHEMA_CLASS    => $class,
                self::SCHEMA_LABEL    => $option->getOptionName(),
                self::SCHEMA_HELP     => $option->getOptionComment(),
                self::SCHEMA_REQUIRED => false,
            );

            if ($this->isOptionRequired($option)) {
                $cell[self::SCHEMA_REQUIRED] = true;
            }

            $parameters = $option->getWidgetParameters();
            if ($parameters && is_array($parameters)) {
                $cell += $parameters;
            }
        }

        return $cell;
    }

    /**
     * Detect form field class by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return string
     */
    protected function detectFormFieldClassByOption(\XLite\Model\Config $option)
    {
        $class = null;
        $type = $option->getType() ?: 'text';

        switch ($type) {
            case 'textarea':
                $class = '\XLite\View\FormField\Textarea\Simple';
                break;

            case 'checkbox':
                $class = '\XLite\View\FormField\Input\Checkbox\Simple';
                break;

            case 'country':
                $class = '\XLite\View\FormField\Select\Country';
                break;

            case 'state':
                $class = '\XLite\View\FormField\Select\State';
                break;

            case 'currency':
                $class = '\XLite\View\FormField\Select\Currency';
                break;

            case 'separator':
                $class = '\XLite\View\FormField\Separator\Regular';
                break;

            case 'text':
                $class = '\XLite\View\FormField\Input\Text';
                break;

            case 'hidden':
                break;

            default:
                if (preg_match('/^\\\?XLite\\\/Ss', $option->getType())) {
                    $class = $option->getType();
                }
        }

        return $class;
    }

    /**
     * Check - option is required or not
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return boolean
     */
    protected function isOptionRequired(\XLite\Model\Config $option)
    {
        return false;
    }

    /**
     * Get form fields for default section
     *
     * @return array
     */
    protected function getFormFieldsForSectionDefault()
    {
        $result = $this->getFieldsBySchema($this->getSchemaFields());

        // For country <-> state synchronization
        $this->setStateSelectorIds($result);

        return $result;
    }

    /**
     * Get array of country/states selector fields which should be synchronized
     *
     * @return array
     */
    protected function getCountryStateSelectorFields()
    {
        return array(
            'location_country' => array(
                'location_state',
                'location_custom_state',
            ),
            'anonymous_country' => array(
                'anonymous_state',
                'anonymous_custom_state',
            ),
        );
    }

    /**
     * Pass the DOM IDs of the "State" selectbox to the "CountrySelector" widget
     *
     * @param array &$fields Widgets list
     *
     * @return void
     */
    protected function setStateSelectorIds(array &$fields)
    {
        $data = $this->getCountryStateSelectorFields();

        foreach ($data as $countryField => $stateFields) {
            if (isset($fields[$countryField]) && isset($stateFields[0]) && isset($stateFields[1])) {
                $fields[$countryField]->setStateSelectorIds(
                    preg_replace('/_/', '-', $stateFields[0]), // States selector ID
                    preg_replace('/_/', '-', $stateFields[1])  // Custom state input ID
                );
            }
        }
    }

    /**
     * Get item class
     *
     * @param integer                          $index  Item index
     * @param integer                          $length Items list length
     * @param \XLite\View\FormField\AFormField $field  Current item
     *
     * @return string
     */
    protected function getItemClass($index, $length, \XLite\View\FormField\AFormField $field)
    {
        $data = $this->getCountryStateSelectorFields();

        foreach ($data as $countryField => $stateFields) {
            if ($stateFields[1] === $field->getName()) {
                $this->rowIndexDelta++;
            }
        }

        $index += $this->rowIndexDelta;

        $classes = parent::getItemClass($index, $length, $field);

        return $classes;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();
        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => 'Submit',
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action',
            )
        );

        if ('css_js_performance' === $this->getTarget()) {
            $url = $this->buildURL('css_js_performance', 'clean_aggregation_cache');
            $result['clear_aggregation_cache'] = new \XLite\View\Button\Tooltip(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Clean aggregation cache',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
                    \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Clean aggregation cache help text'),
                    \XLite\View\Button\Regular::PARAM_JS_CODE => 'self.location=\'' . $url . '\'',
                )
            );

            $url = $this->buildURL('css_js_performance', 'clean_view_cache');
            $result['clear_widgets_cache'] = new \XLite\View\Button\Tooltip(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Clean widgets cache',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
                    \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Clean widgets cache help text'),
                    \XLite\View\Button\Regular::PARAM_JS_CODE => 'self.location=\'' . $url . '\'',
                )
            );
        }

        if ('cache_management' === $this->getTarget()) {
            $url = $this->buildURL('cache_management', 'rebuild');
            $result['re_deploy_cache'] = new \XLite\View\Button\Tooltip(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Re-deploy the store',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
                    \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Re-deploy the store help text'),
                    \XLite\View\Button\Regular::PARAM_JS_CODE => sprintf('if (confirm(core.t("Are you sure?"))) self.location="%s";', $url),
                )
            );

            $url = $this->buildURL('cache_management', 'quick_data');
            $result['quick_data'] = new \XLite\View\Button\Tooltip(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Calculate quick data',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
                    \XLite\View\Button\Tooltip::PARAM_SEPARATE_TOOLTIP => static::t('Calculate quick data help text'),
                    \XLite\View\Button\Regular::PARAM_JS_CODE => 'self.location=\'' . $url . '\'',
                )
            );
        }

        return $result;
    }

    /**
     * Perform certain action for the model object
     *
     * @return boolean
     */
    protected function performActionUpdate()
    {
        return true;
    }

    /**
     * Retrieve property from the model object
     *
     * @param mixed $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        $value = null;

        foreach ($this->getOptions() as $option) {
            if ($option->getName() === $name) {
                $value = $option->getValue();
                break;
            }
        }

        return $value;
    }

    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        $optionsToUpdate = array();

        // Find changed options and store them in $optionsToUpdate
        foreach ($this->getEditableOptions() as $key => $option) {
            $name  = $option->name;
            $type  = $option->type;
            $value = $option->value;

            $category = $option->category;
            $validationMethod = 'sanitize'
                . \Includes\Utils\Converter::convertToCamelCase($category)
                . \Includes\Utils\Converter::convertToCamelCase($name);

            if (method_exists($this, $validationMethod)) {
                $data[$name] = $this->$validationMethod($data[$name]);
            }

            if ('checkbox' === $type) {
                $newValue = empty($data[$name]) ? 'N' : 'Y';

            } elseif ('serialized' === $type && isset($data[$name]) && is_array($data[$name])) {
                $newValue = serialize($data[$name]);

            } elseif ('text' === $type) {
                $newValue = array_key_exists($name, $data) ? (null !== $data[$name] ? trim($data[$name]) : null) : '';

            } else {
                $newValue = array_key_exists($name, $data) ? $data[$name] : '';
            }

            if (null !== $newValue && $value != $newValue) {
                $option->value = $newValue;
                $optionsToUpdate[] = $option;
            }
        }

        // Save changed options to the database
        if (!empty($optionsToUpdate)) {
            foreach ($optionsToUpdate as $option) {
                if ($this->preprocessOption($option)) {
                    \XLite\Core\Database::getRepo('\XLite\Model\Config')->createOption(
                        array(
                            'category' => $option->category,
                            'name'     => $option->name,
                            'value'    => $option->value
                        )
                    );
                }
            }
        }
    }

    /**
     * Preprocess option change and return true on success
     *
     * @param \XLite\Model\Config $option Option entity
     *
     * @return boolean
     */
    protected function preprocessOption($option)
    {
        $result = true;

        $method = 'preprocess' . \XLite\Core\Converter::convertToCamelCase($option->name) . 'Option';

        if (method_exists($this, $method)) {
            $result = $this->$method($option);
        }

        return $result;
    }

    /**
     * Preprocess option Environment - update_wave
     *
     * @param \XLite\Model\Config $option Option entity
     *
     * @return boolean
     */
    protected function preprocessUpgradeWaveOption($option)
    {
        $result = false;

        $value = $option->value;

        $waves = \XLite\Core\Marketplace::getInstance()->getWaves();

        if ($waves && isset($waves[$value])) {
            if (\XLite\Core\Marketplace::getInstance()->changeKeysWave($value)) {
                \XLite\Core\TopMessage::addInfo('Upgrade access level has been successfully assigned to your license keys');
                $result = true;

            } else {
                \XLite\Core\TopMessage::addError('Could not assign upgrade access level to your license keys');
            }
        }

        return $result;
    }

    /**
     * Get editable options
     *
     * @return array
     */
    protected function getEditableOptions()
    {
        $options = $this->getOptions();
        $exclude = array('separator', 'hidden');
        foreach ($options as $key => $option) {
            if (in_array($option->type, $exclude)) {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Profile
     */
    protected function getDefaultModelObject()
    {
        return null;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\View\Form\Settings';
    }

    /**
     * Sanitize value of option Company->company_website
     *
     * @param string $value Input value
     *
     * @return string
     */
    protected function sanitizeCompanyCompanyWebsite($value)
    {
        $value = trim($value);

        if (!empty($value)) {
            $value = preg_replace('/^(http:\/\/|http(s):\/\/|((\w{1,6}):\/\/)|)(.+)$/', 'http\\2://\\5', $value);
        }

        return $value;
    }
}
