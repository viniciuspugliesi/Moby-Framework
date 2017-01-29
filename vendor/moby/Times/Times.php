<?php

namespace Times;

use \DateTime;
use Times\Interfaces\InterfaceTimes;

class Times implements InterfaceTimes
{
    /**
     * Return the date according parameter
     * 
     * @param string $format
     * @return string
     */
    public static function date($format = 'Y-m-d')
    {
        return DateTime::createFromFormat($format, date('Y-m-d'))->format($format);
    }
    
    
    /**
     * Return the date according parameter
     * 
     * @param string $format
     * @return string
     */
    public static function now($format = 'Y-m-d')
    {
        return DateTime::createFromFormat($format, date('Y-m-d'))->format($format);
    }
    
    
    /**
     * Return the time according parameter
     * 
     * @param string $format
     * @return string
     */
    public static function time($format = 'H:i:s')
    {
        return DateTime::createFromFormat($format, date('H:i:s'))->format($format);
    }
    
    
    /**
     * Return the difference of date1 and date2 according parameter
     * 
     * @param string $date1
     * @param string $date2
     * @return float
     */
    public static function diff($date1, $date2, $return = 'y-m-d')
    {
        if (strripos($return, '-')) {
            $return = explode('-', strtolower($return));
            
        } else if (strripos($return, '/')) {
            $return = explode('/', strtolower($return));
            
        } else {
            return false;
        }
        
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);
        
        $interval = $date1->diff($date2);
        
        $diff = '';
        
        foreach ($return as $valeu) {
            $diff .= $interval->$valeu . '-';
        }
        
        return substr($diff, 0, -1);
    }
}