<?php

namespace Auth;

use Session\Session;
use Auth\Interfaces\InterfaceAuth;
use Exception\RenderException;

/**
 * Auth class responsible for the autentication users
 */
class Auth implements InterfaceAuth
{
    /**
     * Verify if has user 
     * 
     * @param string $user
     * @return bool
     */
    public function hasAuth($user)
    {
        $this->auth();
        
        foreach ($this->_users as $u) {
            if ($u['name'] == $user && Session::has($user)) {
                return true;
            }
        }

        return false;
    }
}