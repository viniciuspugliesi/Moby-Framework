<?php

namespace Console;

use Console\Interfaces\InterfaceConsole;

/**
 * 
 */
class ConsoleScaffold implements InterfaceConsole
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
        $this->$arguments;
    }
}