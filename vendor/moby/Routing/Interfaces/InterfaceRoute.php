<?php

namespace Routing\Interfaces;

/**
 * Interface for the Route class
 *
 * @package Route
 * @author `Vinicius Pugliesi`
 */
interface InterfaceRoute
{
    public static function any($route, $call);
    
    public static function get($route, $call);
    
    public static function post($route, $call);
    
    public static function put($route, $call);
    
    public static function delete($route, $call);
    
    public static function group($route, $call);
    
    public static function middleware($auth, $call = false);
    
    public function name($name);
    
    public function where(array $where);
    
    public static function run();
}