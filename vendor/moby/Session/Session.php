<?php

namespace Session;

/**
 * Classe de Sessão do pugliesiFramework
 */
class Session
{
    /**
     * Returns one session Specific or all
     * 
     * @param string $key
     * @return string
     */
    public static function get($key = false)
    {
        if (!$key) {
            return $_SESSION;
        }
        
        if (!isset($_SESSION[$key]) || !$_SESSION[$key]) {
            return false;
        }
        
        return $_SESSION[$key];
    }
    
    
    /**
     * Create one new session
     * 
     * @param string/array $key
     * @param string $value
     * @return bool
     */
    public static function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
        } else {
            $_SESSION[$key] = $value;
        }
        
        return true;
    }
    
    
    /**
     * Verify if exists one session
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        if (!isset($_SESSION[$key]) || !$_SESSION[$key]) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Set one session frashdata
     * 
     * @param string/array $key
     * @param string $value
     * @return bool
     */
    public static function flash($key, $value)
    {
        if (is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
                    
        else
            $_SESSION[$key] = $value;
        
        return true;
    }
    
    
    /**
     * Destroy the session
     * 
     * @param string $key
     * @return boll
     */
    public static function forget($key)
    {
        return Session::SessionDestroy($key);
    }
    
    
    /**
     * Destroy all sessions
     * 
     * @return bool
     */
    public static function forgetAll()
    {
        return Session::SessionDestroy();
    }
    
    
    /**
     * Destroy one session espefic or all
     * 
     * @return bool
     */
    private static function SessionDestroy($key = false)
    {
        if (!$key)
            return session_destroy();
        
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
            
        return false;
    }
}