<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Catalog
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Catalog\Model\Indexer\Product\Flat;

class Processor
{
    /**
     * Indexer ID
     */
    const INDEXER_ID = 'catalog_product_flat';

    /**
     * @var \Magento\Indexer\Model\IndexerInterface
     */
    protected $_indexer;

    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Flat\State
     */
    protected $_state;

    /**
     * @param \Magento\Indexer\Model\IndexerFactory $indexerFactory
     * @param \Magento\Catalog\Model\Indexer\Product\Flat\State $state
     */
    public function __construct(
        \Magento\Indexer\Model\IndexerFactory $indexerFactory,
        \Magento\Catalog\Model\Indexer\Product\Flat\State $state
    ) {
        $this->_indexer = $indexerFactory->create();
        $this->_state = $state;
    }

    /**
     * Get indexer instance
     *
     * @return \Magento\Indexer\Model\Indexer
     */
    public function getIndexer()
    {
        if (!$this->_indexer->getId()) {
            $this->_indexer->load(self::INDEXER_ID);
        }
        return $this->_indexer;
    }

    /**
     * Reindex single row by id
     *
     * @param int $id
     * @return void
     */
    public function reindexRow($id)
    {
        if (!$this->_state->isFlatEnabled() || $this->getIndexer()->isScheduled()) {
            return;
        }
        $this->getIndexer()->reindexRow($id);
    }

    /**
     * Reindex multiple rows by ids
     *
     * @param int[] $ids
     * @return void
     */
    public function reindexList($ids)
    {
        if (!$this->_state->isFlatEnabled() || $this->getIndexer()->isScheduled()) {
            return;
        }
        $this->getIndexer()->reindexList($ids);
    }

    /**
     * Run full reindex
     *
     * @return void
     */
    public function reindexAll()
    {
        if (!$this->_state->isFlatEnabled()) {
            return;
        }
        $this->getIndexer()->reindexAll();
    }

    /**
     * Mark Product flat indexer as invalid
     *
     * @return void
     */
    public function markIndexerAsInvalid()
    {
        if (!$this->_state->isFlatEnabled()) {
            return;
        }
        $this->getIndexer()->invalidate();
    }
}
