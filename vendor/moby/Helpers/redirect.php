<?php

use Response\Response;
use Session\Session;

/**
 * Function redirect URL
 *
 * @param  string $dir
 * @return redirect for URL
 */	
function redirect($dir = null) {
    if ($dir) {
        header('Location: '.$dir);
    } else {
        Session::flash('redirect', true);
    }
    
    return new Response();
}