<?php

namespace Exception;

use App\Exceptions\ConfigException;
use Exception\Interfaces\InterfaceException;

/**
 * Exception class for all generic functions for the Exception 
 */
class RenderException extends ConfigException implements InterfaceException
{
    /**
     * Render error view with existing errors
     * 
     * @param array $args
     * @param string $view
     * @return include view
     */ 
    public function render($view, $args = [])
    {
        try {
            if (!file_exists(__DIR__ . '/../../../App/Views/' . $view . '.php')) {
                throw new Exception('Default view error not found', 1110);
            }
            
            include(__DIR__ . '/../../../App/Views/' . $view . '.php');
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        die();
    }
}