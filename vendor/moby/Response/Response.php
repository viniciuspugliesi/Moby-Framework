<?php

namespace Response;

use Session\Session;
use Http\Request;
use Exception\RenderException;
use Response\Interfaces\InterfaceResponse;

/**
 * 
 * 
 */	
class Response implements InterfaceResponse
{
    /**
     * 
     * 
     */ 
    private $view = false;
    
    /**
     * 
     * 
     */ 
    public function __construct($view = false)
    {
        if ($view)
            $this->view = true;
    }
    
    /**
     * 
     * 
     */ 
    public function back()
    {
        if (Session::getFlashdata('redirect'))
            header('Location: ');
        
        return $this;
    }
    
    /**
     * 
     * 
     */ 
    public function with($params = [])
    {
        if ($this->view) {
            
            $this->view = false;
            extract($params);
            
        } else {
            foreach($params as $key => $value)
                Session::flashdata($key, $value);
        }
        
        return $this;
    }
}