<?php

/**
 * Optimiseweb SuggestedProducts Block List Promotion
 *
 * @package     Optimiseweb_SuggestedProducts
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_SuggestedProducts_Block_List_Promotion extends Mage_Catalog_Block_Product_List {

    protected function _getProductCollection() {
        if (is_null($this->_productCollection)) {
            $collection = Mage::getResourceModel('catalog/product_collection');
            Mage::getModel('catalog/layer')->prepareProductCollection($collection);
            /* $collection->addAttributeToFilter('promotion', 1); */
            $collection->addStoreFilter();
            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }

}
