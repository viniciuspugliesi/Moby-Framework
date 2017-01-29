<?php

namespace Response\Interfaces;

/**
 * Interface of Response class
 *
 * @package Response
 * @author `Vinicius Pugliesi`
 */
interface InterfaceResponse
{
    public function __construct($view = false);
    
    public function back();
    
    public function with($params = []);
}