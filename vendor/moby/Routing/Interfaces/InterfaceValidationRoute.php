<?php

namespace Routing\Interfaces;

/**
 * Interface for the ValidationRoute class
 *
 * @package Routing
 * @author `Vinicius Pugliesi`
 */
interface InterfaceValidationRoute
{
    public function hasLocalhost();
    
    public function hasGroup($group, $route);
    
    public function hasparam($route, $uri);
    
    public function hasWhere();
    
    public function hasUppercase();
    
    public function isURL($route, $uri);
    
    public function clearparams($route = false);
}