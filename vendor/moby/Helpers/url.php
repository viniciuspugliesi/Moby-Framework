<?php

use Http\Request;

/**
 * Get current URL
 *
 * @return string
 */	
function currentURL() {
    return Request::getCurrentURL();
}


/**
 * Get baseURL with param 
 *
 * @param  string $concat
 * @return baseURL with param
 */	
function url($concat) {
    return $concat;
}