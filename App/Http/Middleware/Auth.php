<?php

namespace App\Http\Middleware;

use Auth\Auth as BaseAuth;

/**
 * 
 */
class Auth extends BaseAuth
{
    /**
     * 
     */
    public function redirect()
    {
        return redirect('/');
    }
}