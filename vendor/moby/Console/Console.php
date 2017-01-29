<?php

namespace Console;

use Console\AbstractConsole;

/**
 * 
 */
class Console extends AbstractConsole
{
    /**
     * 
     */
    private $arguments = [];
    
    
    /**
     * 
     */
    private $commands = [
        'help', 'model', 'controller', 'models', 
        'request', 'scaffold'
    ];
    
    
    /**
     * 
     */
    public function __construct($arguments)
    {
        array_shift($arguments);
        $this->arguments = $arguments;
    }
    
    
    /**
     * 
     */
    public function run()
    {
        // // TESTE
        //     if(!defined("STDIN")) {
        //         define("STDIN", fopen('php://stdin','r'));
        //     }
                
        //     do {
        //         echo ">>> ";
        //         $strName = fread(STDIN, 40); // Read up to 40 characters or a newline
                
        //         // echo($this->responseColor($strName, '', 'red'));
        //         if (strlen($strName) > 1) {
        //             if (substr($strName, -1) != ';') {
        //                 $strName .= ';';
        //             }
        //             eval($strName);
        //             echo "\n";
        //         }
        //     } while(true);
                
        //     die('Finalizou o looping');
        // // FIM TESTE
        
        if (!$this->arguments) {
            return $this->getSuccessCommand(1);
        }
        
        if (!$this->validationCommand()) {
            return $this->getErrorCommand(1, $this->arguments[0]);
        }
        
        if (!$status = $this->executeCommand()) {
            return $this->getErrorCommand(1, $this->arguments[0]);
        }
            
        return $status . " \n";
    }
    
    
    /**
     * 
     */
    private function validationCommand()
    {
        foreach ($this->commands as $command) {
            if ($this->arguments[0] === $command) {
                if ($this->arguments[0] != 'models') {
                    return true;
                }
                
                if (isset($this->arguments[1]) && $this->arguments[1] == '--database') {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    
    /**
     * 
     */
    private function executeCommand()
    {
        if ($this->arguments[0] == 'help')
            return $this->getSuccessCommand(2);
            
        $class = 'Console\\Console'.ucwords($this->arguments[0]);
        
        array_shift($this->arguments);
        
        return $class::run($this->arguments);
    }
}