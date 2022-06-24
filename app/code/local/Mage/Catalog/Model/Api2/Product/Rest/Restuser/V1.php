<?php

class Mage_Catalog_Model_Api2_Product_Rest_Restuser_V1 extends Mage_Catalog_Model_Api2_Product_Rest_Admin_V1
{
    /**
     * @inheritDoc
     */
    protected function _getProduct()
    {
        if (is_null($this->_product)) {
            $productId = $this->getRequest()->getParam('id');
            /** @var Mage_Catalog_Helper_Product $productHelper */
            $productHelper = Mage::helper('catalog/product');
            $product = $productHelper->getProduct($productId, $this->_getStore()->getId());
            if (!($product->getId())) {
                $this->_critical(self::RESOURCE_NOT_FOUND);
            }
            // check if product belongs to website current
            if ($this->_getStore()->getId()) {
                $isValidWebsite = in_array($this->_getStore()->getWebsiteId(), $product->getWebsiteIds());
                if (!$isValidWebsite) {
                    $this->_critical(self::RESOURCE_NOT_FOUND);
                }
            }

            $this->_product = $product;
        }
        return $this->_product;
    }
}
