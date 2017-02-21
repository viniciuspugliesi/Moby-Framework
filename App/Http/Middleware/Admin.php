<?php

namespace App\Http\Middleware;

use Auth\Auth as BaseAuth;

/**
 * 
 */
class Admin extends BaseAuth
{
    /**
     * 
     */
    public function redirect()
    {
        return redirect('/');
    }
}