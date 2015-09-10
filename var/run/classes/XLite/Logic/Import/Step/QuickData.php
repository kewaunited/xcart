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

namespace XLite\Logic\Import\Step;

/**
 * Rebuild quick data step
 */
class QuickData extends \XLite\Logic\Import\Step\AStep
{
    /**
     * Get final note
     *
     * @return string
     */
    public function getFinalNote()
    {
        return static::t('Products processed');
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return static::t('Processing products...');
    }

    /**
     * Process row
     *
     * @return boolean
     */
    public function process()
    {
        if (empty($this->getOptions()->commonData['qdProcessed'])) {
            $this->getOptions()->commonData['qdProcessed'] = 0;
        }

        $chunkLength = 1;

        if (isset($this->getOptions()->commonData['calculateAllQuickData'])) {
            $items = \XLite\Core\Database::getRepo('XLite\Model\Product')
                ->getQuickDataIterator($this->getOptions()->commonData['qdProcessed']);
            $items->rewind();
            $processed = 0;

            while ($chunkLength--) {
                /** @var \XLite\Model\Product $item */
                $item = $items->current();
                if (null === $item || !isset($item[0])) {
                    break;
                }

                $item[0]->updateQuickData();
                $processed++;
                $items->next();
            }

        } else {
            $processed = \XLite\Core\QuickData::getInstance()->updateUnprocessedChunk($chunkLength);
        }

        $this->getOptions()->commonData['qdProcessed'] += $processed;

        return $processed == 1;
    }

    /**
     * \Counable::count
     *
     * @return integer
     */
    public function count()
    {
        if (!isset($this->getOptions()->commonData['qdCount'])) {
            $this->getOptions()->commonData['qdCount'] = isset($this->getOptions()->commonData['calculateAllQuickData'])
                ? \XLite\Core\Database::getRepo('XLite\Model\Product')->countForQuickData()
                : \XLite\Core\QuickData::getInstance()->countUnprocessed();
        }

        return $this->getOptions()->commonData['qdCount'];
    }

    /**
     * Check - allowed step or not
     *
     * @return boolean
     */
    public function isAllowed()
    {
        return parent::isAllowed()
            && $this->count() > 0;
    }

    /**
     * Get error language label
     *
     * @return array
     */
    public function getErrorLanguageLabel()
    {
        $options = $this->getOptions();

        return static::t(
            'Products processed: X out of Y with errors',
            array(
                'X'      => $options->position,
                'Y'      => $this->count(),
                'errors' => $options->errorsCount,
                'warns'  => $options->warningsCount,
            )
        );
    }

    /**
     * Get normal language label
     *
     * @return array
     */
    public function getNormalLanguageLabel()
    {
        $options = $this->getOptions();

        return static::t(
            'Products processed: X out of Y',
            array(
                'X' => $options->position,
                'Y' => $this->count(),
            )
        );

    }

    /**
     * Get messages
     *
     * @return array
     */
    public function getMessages()
    {
        $list = parent::getMessages();

        if (!empty($this->getOptions()->commonData['qdProcessed'])) {
            $list[] = array(
                'text' => static::t('Products processed: {{count}}', array('count' => $this->getOptions()->commonData['qdProcessed'])),
            );
        }

        return $list;
    }
}
