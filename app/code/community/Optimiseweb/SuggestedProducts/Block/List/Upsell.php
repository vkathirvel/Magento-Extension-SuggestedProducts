<?php

/**
 * Optimiseweb SuggestedProducts Block List Upsell
 *
 * @package     Optimiseweb_SuggestedProducts
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_SuggestedProducts_Block_List_Upsell extends Mage_Catalog_Block_Product_Abstract {

    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_noform';
    protected $_items;
    protected $_itemCollection;

    protected function _prepareData() {
        $product = Mage::registry('product');

        /* @var $product Mage_Catalog_Model_Product */
        $collection = $product->getUpSellProductCollection();

        /* Randomize */
        if ($this->getRandomize()) {
            $collection->getSelect()->order('rand()');
        } else {
            /* $collection->addAttributeToSort('position', 'asc'); */
            $collection->setPositionOrder();
        }
        $collection->addStoreFilter();

        /* Product Count */
        $numProducts = $this->getNumProducts() ? $this->getNumProducts() : 0;
        /* $collection->setPageSize(1, $numProducts); */
        $collection->setPage(1, $numProducts);

        $this->_itemCollection = $collection;

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection, Mage::getSingleton('checkout/session')->getQuoteId());
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
        /* Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection); */
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        $this->_itemCollection->load();

        /**
         * Updating collection with desired items
         */
        Mage::dispatchEvent('optimiseweb_suggestedproducts_list_upsell', array(
            'product' => $product,
            'collection' => $this->_itemCollection,
            'limit' => $numProducts
        ));

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    protected function _beforeToHtml() {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    public function getItemCollection() {
        return $this->_itemCollection;
    }

    public function getItems() {
        if (is_null($this->_items)) {
            $this->_items = $this->getItemCollection()->getItems();
        }
        return $this->_items;
    }

}
