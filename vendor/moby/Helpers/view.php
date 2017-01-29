<?php

use View\View;

/**
 * Function returns of views
 *
 * @param  string $view
 * @param  string $paran (parameter for the view) 
 * 
 * @return object Response()
 */	
function view($view, $param = [])
{
    $view = new View($view, $param);
    
    return $view->initialize();
}