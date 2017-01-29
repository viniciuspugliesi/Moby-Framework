<?php

namespace Times\Interfaces;

/**
 * Interface of Times class
 *
 * @package Times
 * @author `Vinicius Pugliesi`
 */
interface InterfaceTimes
{
    public static function date($format = 'Y-m-d');
    
    public static function now($format = 'Y-m-d');
    
    public static function time($format = 'H:i:s');
    
    // public static function diff($date1, $date2);
    
    // public static function compare($date1, $compare, $date2);
}