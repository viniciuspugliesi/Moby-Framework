<?php

namespace Session\Interfaces;

/**
 * Interface for the Session class
 *
 * @package Session
 * @author `Vinicius Pugliesi`
 */
interface InterfaceSession
{
    public static function get($key = false);
    
    public static function pull($key = false);
    
    public static function put($key, $value = null);
    
    public static function set($key, $value = null);
    
    public static function push($key, $value);
    
    public static function has($key);
    
    public static function flashdata($key, $value);
    
    public static function flash($key, $value);
    
    public static function setFlashdata($key, $value);
    
    public static function getFlashdata($key = false);
    
    public static function getFlash($key = false);
    
    public static function hasFlashdata($key);
    
    public static function destroyFlashdata($key);
    
    public static function destroyAll();
    
    public static function SessionDestroy($key = false);
}