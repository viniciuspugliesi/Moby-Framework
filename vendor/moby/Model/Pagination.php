<?php

namespace Model;

use System\System;
use Model\Interfaces\InterfacePagination;

/**
 * 
 */
class Pagination extends System implements InterfacePagination
{
    /**
     * 
     */
    public $per_page;
    
    /**
     * 
     */
    public $page;
    
    
    
    /**
     * 
     */
    public function paginate($number)
    {
        $this->page     = $this->getParamGet();
        $this->per_page = $number;
        
        $this->_limit  = $number;
        $this->_offset = $this->getParamGet();
        $this->getQuery();
        
        $this->_query = array_merge(
            (array) $this->_query->fetchAll(\PDO::FETCH_OBJ),
            (array) $this
        );
        
        return $this->_query;
    }
}