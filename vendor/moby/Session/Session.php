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
     * Returns one session Specific or all
     * 
     * @param string $key
     * @return string
     */
    public static function pull($key = false)
    {
        if (!$_SESSION[$key])
            return $_SESSION;
            
        return $_SESSION[$key];
    }
    
    
    /**
     * Create one new session
     * 
     * @param string/array $key
     * @param string $value
     * @return bool
     */
    public static function put($key, $value = null)
    {
        if (is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
        
        else
            $_SESSION[$key] = $value;

        return true;
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
     * Create one new session
     * 
     * @param string/array $key
     * @param string $value
     * @return bool
     */
    public static function push($key, $value)
    {
        if (is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
        
        else
            $_SESSION[$key] = $value;

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
    public static function flashdata($key, $value)
    {
        if (is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
                    
        else
            $_SESSION[$key] = $value;
        
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
     * Set one session frashdata
     * 
     * @param string/array $key
     * @param string $value
     * @return bool
     */
    public static function setFlashdata($key, $value)
    {
        if (is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
                    
        else
            $_SESSION[$key] = $value;
        
        return true;
    }
    
    
    /**
     * Returns one session flashdata
     * 
     * @param string $key
     * @return string/bool
     */
    public static function getFlashdata($key = false)
    {
        if (!$_SESSION[$key])
            return $_SESSION;
            
        return $_SESSION[$key];
    }
    
    
    /**
     * Returns one session flashdata
     * 
     * @param string $key
     * @return string/bool
     */
    public static function getFlash($key = false)
    {
        if (!$_SESSION[$key])
            return $_SESSION;
            
        return $_SESSION[$key];
    }
    
    
    /**
     * Verify if exists the session frashdata
     * 
     * @param string $key
     * @return bool
     */
    public static function hasFlashdata($key)
    {
        if (!$_SESSION[$key])
            return false;
            
        return true;
    }
    
    
    /**
     * Destroy the session frashdata
     * 
     * @param string $key
     * @return boll
     */
    public static function destroyFlashdata($key)
    {
        return Session::SessionDestroy($key);
    }
    
    
    /**
     * Destroy the session
     * 
     * @param string $key
     * @return boll
     */
    public static function destroy($key)
    {
        return Session::SessionDestroy($key);
    }
    
    
    /**
     * Destroy the session
     * 
     * @param string $key
     * @return boll
     */
    public static function delete($key)
    {
        return Session::SessionDestroy($key);
    }
    
    
    /**
     * Destroy all sessions
     * 
     * @return bool
     */
    public static function destroyAll()
    {
        return Session::SessionDestroy();
    }
    
    
    /**
     * Destroy one session espefic or all
     * 
     * @return bool
     */
    public static function SessionDestroy($key = false)
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