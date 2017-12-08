<?php

namespace Distinctive\CustomSort\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class SortList implements ArrayInterface
{
    public static $sortListArray = array(
        'bestseller' => 'Best Seller',
        'newest'     => 'Newest',
        'mostviewed' => 'Most Viewed'
    );

    public function toOptionArray($isMultiselect = false)
    {
        $sortList = [];
        foreach (self::$sortListArray as $key => $value)
        {
            $sortList[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        if (!$isMultiselect) {
            array_unshift($sortList, ['value' => '', 'label' => __('--Please Select--')]);
        }

        return $sortList;
    }

    public function getOriginalOption()
    {
        return self::$sortListArray;
    }
}