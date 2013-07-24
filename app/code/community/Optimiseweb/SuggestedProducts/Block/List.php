<?php

/**
 * Optimiseweb SuggestedProducts Block List
 *
 * @package     Optimiseweb_SuggestedProducts
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_SuggestedProducts_Block_List extends Mage_Catalog_Block_Product_Abstract
{

    protected $_mapRenderer = 'msrp_item';
    protected $_itemCollection;

    /**
     *
     * @return \Optimiseweb_SuggestedProducts_Block_List
     */
    protected function _prepareData()
    {
        $product = Mage::registry('product');

        $suggestion = $this->getSuggestion() ? $this->getSuggestion() : 'category';

        /* Product Collection */
        $collection = Mage::getResourceModel('catalog/product_collection');
        /* Eliminate the Current Product */
        $collection->addAttributeToFilter('entity_id', array('nin' => array($product->getId())));

        /* Category Suggestion */
        if ($suggestion == 'category') {
            $categories = $product->getCategoryIds();
            $collection->addCategoryFilter(Mage::getModel('catalog/category')->load($categories[0]));
        }

        /* Attribute Suggestion */
        if ($suggestion == 'attribute') {
            /* Check if an attribute code is provided */
            if ($this->getAttributeCode()) {
                $productAttribute = $product->getData($this->getAttributeCode());
                $collection->addAttributeToFilter($this->getAttributeCode(), array('eq' => $productAttribute));
            }
        }

        /* Randomize */
        if ($this->getRandomize()) {
            $collection->getSelect()->order('rand()');
        }

        /* Store Filter */
        $collection->addStoreFilter();

        /* Product Count */
        $numProducts = $this->getNumProducts() ? $this->getNumProducts() : 0;
        $collection->setPage(1, $numProducts);

        $this->_itemCollection = $collection;

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection, Mage::getSingleton('checkout/session')->getQuoteId());
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
        /* Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection); */
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    /**
     * Before rendering html process
     * Prepare items collection
     *
     * @return type
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve crosssell items collection
     *
     * @return type
     */
    public function getItems()
    {
        return $this->_itemCollection;
    }

}