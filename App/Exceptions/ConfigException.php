<?php

namespace App\Exceptions;

use Exception;

/**
 * 
 */
class ConfigException extends Exception
{
    /**
     * 
     */
    public static $maintenance = false;
    
    
    /**
     * 
     */
    public function showErrors()
    {
        return 'Exceptions/default-error';
    }
    
    
    /**
     * 
     */
    public function routeNotFound()
    {
        return 'Exceptions/default-error';
    }
    
    
    /**
     * 
     */
    public static function maintenanceWebsite()
    {
        // return view('Exceptions/maintenance-website');
    }
}