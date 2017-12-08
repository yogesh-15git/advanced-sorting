<?php

namespace Distinctive\CustomSort\Model;

use Distinctive\CustomSort\Model\Config\Source\SortList;

class Config extends \Magento\Catalog\Model\Config
{
    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $options = parent::getAttributeUsedForSortByArray();

        $sortList = $this->_scopeConfig->getValue('catalog/custom_sort/sort_list', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if(strlen($sortList) < 1)
        {
            return $options;
        }

        $sortList = explode(',', $sortList);
        $list = SortList::$sortListArray;

        foreach ($sortList as $key => $value)
        {
            $options[$value] = $list[$value];
        }

        foreach ($this->getAttributesUsedForSortBy() as $attribute)
        {
            /* @var $attribute \Magento\Eav\Model\Entity\Attribute\AbstractAttribute */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }

        return $options;
    }

    /**
     * Retrieve Product List Default Sort By
     *
     * @param mixed $store
     * @return string
     */
    public function getProductListDefaultSortBy($store = null)
    {
        $defaultSort = $this->_scopeConfig->getValue('catalog/custom_sort/default_sort', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $defaultSort ? $defaultSort : parent::getProductListDefaultSortBy();
    }
}