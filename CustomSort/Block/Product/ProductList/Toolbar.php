<?php

namespace Distinctive\CustomSort\Block\Product\ProductList;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    public function setCollection($collection)
    {
        if($this->getCurrentOrder() == "bestseller")
        {
            $collection->getSelect()->joinLeft(
                'sales_order_item',
                'e.entity_id = sales_order_item.product_id',
                array('qty_ordered' => 'SUM(sales_order_item.qty_ordered)'))
                ->group('e.entity_id')
                ->order('qty_ordered ' . $this->getCurrentDirectionReverse());
        }

        if($this->getCurrentOrder() == "newest")
        {
            $collection->getSelect()
                ->order('created_at ' . $this->getCurrentDirectionReverse());
        }

        if($this->getCurrentOrder() == "mostviewed")
        {
            $collection->getSelect()->joinLeft(
                'report_event',
                'e.entity_id = report_event.object_id',
                array('view_count' => 'COUNT(report_event.event_id)'))
                //->where('report_event.event_type_id = ?',1)
                ->group('e.entity_id')
                ->order('view_count ' . $this->getCurrentDirectionReverse());
        }

        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        $limit = (int)$this->getLimit();
        if($limit)
        {
            $this->_collection->setPageSize($limit);
        }
        if($this->getCurrentOrder())
        {
            $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
        }
        return $this;
    }

    public function getCurrentDirectionReverse()
    {
        if($this->getCurrentDirection() == 'asc')
        {
            return 'desc';
        }
        elseif($this->getCurrentDirection() == 'desc')
        {
            return 'asc';
        }
        else
        {
            return $this->getCurrentDirection();
        }
    }

}