<?php

namespace Console;

use Console\Interfaces\InterfaceConsole;

/**
 * 
 */
class ConsoleController implements InterfaceConsole
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
        ConsoleController::$arguments = $arguments;
        
        $template = ConsoleController::getTemplate();
        
        if (!$newTemplate = ConsoleController::openNewTemplate())
            return ConsoleController::getErrorComand(1);
        
        if (ConsoleController::writeTemplate($template, $newTemplate))
            return ConsoleController::getErrorComand(2);
        
        if (!fclose($newTemplate))
            return ConsoleController::getErrorComand(2);
            
        return ConsoleController::getSuccessComand();
    }
    
    
    /**
     * 
     */
    public static function openNewTemplate()
    {
        if (!ConsoleController::$arguments[0])
            return false;
            
        return fopen('App/Http/Controllers/'.ucwords(ConsoleController::$arguments[0].'Controller.php'), 'w');
    }
    
    
    /**
     * 
     */
    public static function writeTemplate($template, $newTemplate)
    {
        $template = str_replace('[#class#]', ucwords(ConsoleController::$arguments[0]), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function getSuccessComand()
    {
        return "Moby Framework \n \n"
                ."Controller ".ConsoleController::$arguments[0]." successfully Consoled";
    }
    
    
    /**
     * 
     */
    public static function getErrorComand($controlNamberError = 1)
    {
        switch ($controlNamberError) {
            case '1':
                return "Controller name not found in comand: \n"
                        ."$ php moby Console:controller \n"
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
        return file_get_contents('vendor/moby/Console/Templates/ControllerTemplate.php');
    }
}