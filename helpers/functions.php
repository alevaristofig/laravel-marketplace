<?php

function filterItemsByStoreId($items,$store_id)
{
    return array_filter($items,function($line) use($store_id){
        return $line['store_id'] == $store_id;
    });
}
    
