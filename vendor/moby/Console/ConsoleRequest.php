<?php

namespace Console;

use Console\Interfaces\InterfaceConsole;

/**
 * 
 */
class ConsoleRequest implements InterfaceConsole
{
    /**
     * 
     */
    private static $arguments = [];
    
    
    /**
     * 
     */
    public static function run(array $arguments)
    {
        ConsoleRequest::$arguments = $arguments;
        
        $template = ConsoleRequest::getTemplate();
        
        if (!$newTemplate = ConsoleRequest::openNewTemplate())
            return ConsoleRequest::getErrorComand(1);
        
        if (ConsoleRequest::writeTemplate($template, $newTemplate))
            return ConsoleRequest::getErrorComand(2);
        
        if (!fclose($newTemplate))
            return ConsoleRequest::getErrorComand(2);
            
        return ConsoleRequest::getSuccessComand();
    }
    
    
    /**
     * 
     */
    public static function openNewTemplate()
    {
        if (!ConsoleRequest::$arguments[0]) {
            return false;
        }
        
        return fopen('App/Http/Requests/'.ucwords(ConsoleRequest::$arguments[0].'.php'), 'w');
    }
    
    
    /**
     * 
     */
    public static function writeTemplate($template, $newTemplate)
    {
        $template = str_replace('[#class#]', ucwords(ConsoleRequest::$arguments[0]), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function getSuccessComand()
    {
        return "Moby Framework \n \n"
                ."Request ".ConsoleRequest::$arguments[0]." successfully Consoled";
    }
    
    
    /**
     * 
     */
    public static function getErrorComand($controlNamberError = 1)
    {
        switch ($controlNamberError) {
            case '1':
                return "Request name not found in comand: \n"
                        ."$ php moby Console:request \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '2':
                return "Internal server error: \n"
                        ."Try again \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
        }
        
    }
    
    
    /**
     * 
     */
    public static function getTemplate()
    {
        return file_get_contents('vendor/moby/Console/Templates/RequestTemplate.php');
    }
}