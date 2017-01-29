<?php

use Exception\CustomError;

/*
| -------------------------------------------------------------------
|   Register sintaxe errors
| -------------------------------------------------------------------
| 
|   If has sintaxe error in the code, this callable function
|
*/
register_shutdown_function('error_alert'); 

/*
| -------------------------------------------------------------------
|   Calling the autoload of application
| -------------------------------------------------------------------
| 
|   In we have all the dependeces the Moby Framework initiated 
|
*/
function error_alert() {
    if (!$e = error_get_last()) {
        return;
    }
    
    if (defined('STDIN')) {
        return;
    }
    
    $error = new CustomError($e['type'], $e['message'], $e['file'], $e['line']);
    
    $error->initialize();
    die();
}