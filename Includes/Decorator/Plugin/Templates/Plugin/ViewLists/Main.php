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

namespace Includes\Decorator\Plugin\Templates\Plugin\ViewLists;

/**
 * Main 
 *
 */
class Main extends \Includes\Decorator\Plugin\Templates\Plugin\APlugin
{
    /**
     * Parameters for the tags
     */
    const PARAM_TAG_LIST_CHILD_CLASS      = 'class';
    const PARAM_TAG_LIST_CHILD_LIST       = 'list';
    const PARAM_TAG_LIST_CHILD_WEIGHT     = 'weight';
    const PARAM_TAG_LIST_CHILD_ZONE       = 'zone';
    const PARAM_TAG_LIST_CHILD_FIRST      = 'first';
    const PARAM_TAG_LIST_CHILD_LAST       = 'last';
    const PARAM_TAG_LIST_CHILD_CONTROLLER = 'controller';

    /**
     * Temporary index to use in templates hash
     */
    const PREPARED_SKIN_NAME = '____PREPARED____';

    /**
     * List of PHP classes with the "ListChild" tags
     *
     * @var array
     */
    protected $annotatedPHPCLasses;

    /**
     * Check - current plugin is bocking or not
     *
     * @return boolean
     */
    public function isBlockingPlugin()
    {
        return !\Includes\Decorator\Utils\CacheManager::isCapsular();
    }

    /**
     * Execute certain hook handler
     *
     * @return void
     */
    public function executeHookHandler()
    {
        // Truncate old
        if (!\Includes\Decorator\Utils\CacheManager::isCapsular()) {
            $this->clearAll();
        }

        // Create new
        $this->createLists();
    }

    /**
     * Callback to search annotated PHP classes
     *
     * @param \Includes\Decorator\DataStructure\Graph\Classes $node Current node
     *
     * @return void
     */
    public function checkClassForListChildTag(\Includes\Decorator\DataStructure\Graph\Classes $node)
    {
        if (
            !$node->isLowLevelNode()
            && preg_match('/^XLite(?:\\\\Module\\\\[A-Za-z0-9]+\\\\[A-Za-z0-9]+)?\\\\View\\\\/Ss', $node->getClass())
        ) {
            $lists = $node->getTag(static::TAG_LIST_CHILD);
            if ($lists) {
                $data = array('child' => $node->getTopLevelNode()->getClass());

                foreach ($lists as $tags) {
                    $this->annotatedPHPCLasses[] = $data + $tags;
                }
            }
        }
    }

    /**
     * Remove existing lists from database
     *
     * @return void
     */
    protected function clearAll()
    {
        \XLite\Core\Database::getRepo('\XLite\Model\ViewList')->clearAll();
        \XLite\Core\Database::getRepo('\XLite\Model\TemplatePatch')->clearAll();
    }

    /**
     * Create lists
     *
     * @return void
     */
    protected function createLists()
    {
        \XLite\Core\Database::getRepo('\XLite\Model\ViewList')->insertInBatch($this->getAllListChildTags());
    }

    /**
     * Return all defined "ListChild" tags
     *
     * @return array
     */
    protected function getAllListChildTags()
    {
        return array_merge($this->getListChildTagsFromPHP(), $this->getListChildTagsFromTemplates());
    }

    /**
     * Return list of PHP classes with the "ListChild" tag
     *
     * @return array
     */
    protected function getAnnotatedPHPCLasses()
    {
        if (!isset($this->annotatedPHPCLasses)) {
            $this->annotatedPHPCLasses = array();

            static::getClassesTree()->walkThrough(array($this, 'checkClassForListChildTag'));
        }

        return $this->annotatedPHPCLasses;
    }

    /**
     * Return all "ListChild" tags defined in PHP classes
     *
     * @return array
     */
    protected function getListChildTagsFromPHP()
    {
        return $this->getAllListChildTagAttributes($this->getAnnotatedPHPCLasses());
    }

    /**
     * Return all "ListChild" tags defined in templates
     *
     * @return array
     */
    protected function getListChildTagsFromTemplates()
    {
        return $this->getAllListChildTagAttributes($this->prepareListChildTemplates($this->getAnnotatedTemplates()));
    }

    /**
     * Prepare list childs templates-based
     *
     * @param array $list List
     *
     * @return array
     */
    protected function prepareListChildTemplates(array $list)
    {
        $result = array();

        \XLite::getInstance()->initModules();

        $skins = array();
        $hasSubstSkins = false;

        foreach (\XLite\Core\Layout::getInstance()->getSkinsAll() as $interface => $path) {
            $skins[$interface] = \XLite\Core\Layout::getInstance()->getSkins($interface);

            if (!$hasSubstSkins) {
                $hasSubstSkins = 1 < count($skins[$interface]);
            }
        }

        foreach ($list as $i => $cell) {
            foreach ($skins as $interface => $paths) {
                foreach ($paths as $path) {
                    if (0 === strpos($cell['tpl'], $path . LC_DS)) {
                        $length = strlen($path) + ('common' == $path ? 1 : 4);
                        $list[$i]['tpl'] = substr($cell['tpl'], $length);
                        $list[$i]['zone'] = $interface;
                    }
                }
            }

            if (!isset($list[$i]['zone'])) {
                unset($list[$i]);
            }
        }

        if ($hasSubstSkins) {
            $patterns = $hash = array();

            foreach ($skins as $interface => $data) {
                $patterns[$interface] = array();
            
                foreach ($data as $skin) {
                    $patterns[$interface][] = preg_quote($skin, '/');
                }

                $patterns[$interface] = '/^(' . implode('|', $patterns[$interface]) . ')' . preg_quote(LC_DS, '/') . '\w{2}' . preg_quote(LC_DS, '/') . '(.+)$/US';
            }

            foreach ($list as $index => $item) {
                $path = \Includes\Utils\FileManager::getRelativePath($item['path'], LC_DIR_SKINS);

                if (preg_match($patterns[$item['zone']], $path, $matches)) {
                    $hash[$item['zone']][$item['tpl']][$matches[1]] = $index;
                    $list[$index]['tpl'] = $matches[2];
                }
            }

            foreach ($hash as $interface => $tpls) {
                foreach ($tpls as $path => $indexes) {
                    $idx = null;
                    $tags = array();
                    foreach (array_reverse($skins[$interface]) as $skin) {
                        if (isset($indexes[$skin])) {
                            $idx = $indexes[$skin];
                            $tags[] = $list[$indexes[$skin]]['tags'];
                        }
                    }

                    foreach ($this->processTagsQuery($tags) as $tag) {
                        $tmp = $list[$idx];
                        unset($tmp['tags'], $tmp['path']);
                        $result[] = $tmp + $tag;
                    }
                }
            }

            // Convert template short path to UNIX-style
            if (DIRECTORY_SEPARATOR != '/') {
                foreach ($result as $i => $v) {
                    $result[$i]['tpl'] = str_replace(DIRECTORY_SEPARATOR, '/', $v['tpl']);
                }
            }

        } else {

            foreach ($list as $cell) {
                foreach ($this->processTagsQuery(array($cell['tags'])) as $tag) {
                    unset($cell['tags'], $cell['path']);
                    $result[] = $cell + $tag;
                }
            }

        }

        return $result;
    }

    /**
     * Process tags query 
     * 
     * @param array $tags Tags query
     *  
     * @return array
     */
    protected function processTagsQuery(array $tags)
    {
        $result = array();

        foreach ($tags as $step) {
            if (isset($step[static::TAG_CLEAR_LIST_CHILDREN])) {
                $result = array();
            }

            if (isset($step[static::TAG_LIST_CHILD])) {
                $result = $step[static::TAG_LIST_CHILD];
            }

            if (isset($step[static::TAG_ADD_LIST_CHILD])) {
                $result = array_merge($result, $step[static::TAG_ADD_LIST_CHILD]);
            }
        }

        return $result;
    }

    /**
     * Return all defined "ListChild" tag attributes
     *
     * @param array $nodes List of nodes
     *
     * @return array
     */
    protected function getAllListChildTagAttributes(array $nodes)
    {
        return array_map(array($this, 'prepareListChildTagData'), $nodes);
    }

    /**
     * Prepare attributes of the "ListChild" tag
     *
     * @param array $data Tag attributes
     *
     * @return array
     */
    protected function prepareListChildTagData(array $data)
    {
        // Check the weight-related attributes
        $this->prepareWeightAttrs($data);

        // Check for preprocessors
        $this->preparePreprocessors($data);

        return $data;
    }

    /**
     * Check the weight-related attributes
     *
     * @param array &$data Data to prepare
     *
     * @return void
     */
    protected function prepareWeightAttrs(array &$data)
    {
        // The "weight" attribute has a high priority
        if (!isset($data[static::PARAM_TAG_LIST_CHILD_WEIGHT])) {

            // "First" and "last" - the reserved keywords for the "weight" attribute values
            foreach ($this->getReservedWeightValues() as $origKey => $modelKey) {

                if (isset($data[$origKey])) {
                    $data[static::PARAM_TAG_LIST_CHILD_WEIGHT] = $modelKey;
                }
            }
        } else {

            $data[static::PARAM_TAG_LIST_CHILD_WEIGHT] = intval($data[static::PARAM_TAG_LIST_CHILD_WEIGHT]);
        }

        // Set default value
        if (!isset($data[static::PARAM_TAG_LIST_CHILD_WEIGHT])) {
            $data[static::PARAM_TAG_LIST_CHILD_WEIGHT] = \XLite\Model\ViewList::POSITION_LAST;
        }
    }

    /**
     * Check for so called list "preprocessors"
     *
     * @param array &$data Data to use
     *
     * @return void
     */
    protected function preparePreprocessors(array &$data)
    {
        if (isset($data[static::PARAM_TAG_LIST_CHILD_CONTROLLER])) {
            // ...
        }
    }

    /**
     * There are some reserved words for the "weight" param of the "ListChild" tag
     *
     * @return void
     */
    protected function getReservedWeightValues()
    {
        return array(
            static::PARAM_TAG_LIST_CHILD_FIRST => \XLite\Model\ViewList::POSITION_FIRST,
            static::PARAM_TAG_LIST_CHILD_LAST  => \XLite\Model\ViewList::POSITION_LAST,
        );
    }
}
