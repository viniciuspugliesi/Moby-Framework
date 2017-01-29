<?php

namespace Routing;

use Routing\Route;
use Session\Session;
use Validation\Validation;
use Routing\Interfaces\InterfaceValidationRoute;

/**
 * Class responsible for URL and route validation
 */
class ValidationRoute implements InterfaceValidationRoute
{
    /**
     * Function that valid if the route is the same as the url of navigator
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return true or $instance
     */
	public function validar_url($route, $call, $group = false)
	{
        $uri = $this->hasLocalhost();
        
        $this->_url   = $uri;
        $this->_route = $route;
        
        $this->hasGroup($group, $route);
        $this->hasparam($route, $uri);
        $this->hasUppercase();
        
        return $this->isURL($route, $uri);
    }
    
    
    /**
     * Set valid params in the class
     * 
     * @param string OR object $call
     * @param string $_param_url
     * @return void
     */
    public function setValidParams($call, $_param_url)
    {
        static::$_valid_call      = (is_object($call)) ? $call : explode(':', $call);
        static::$_valid_param_url = $_param_url;
    }
    
    
    /**
     * Verify if the environment is localhost and retrieve the parameters of URL
     * 
     * @return string
     */
    public function hasLocalhost()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        if (!$GLOBALS['localhost']) {
            return $uri;
        }
        
        if (substr($uri, 0, 4) != 'http') {
            $uri = 'http://' . $_SERVER['HTTP_HOST'] . $uri;
        }

        if (!$GLOBALS['baseurl']) {
            return $uri;
        }
        
        $uri = str_replace($GLOBALS['baseurl'], '', $uri);
        
        return empty($uri) ? '/' : $uri;
    }
    
    
    /**
     * Verify if the route it's inside in group and format the route/url
     * 
     * @param bool $group
     * @param string $route
     * @return void
     */
    public function hasGroup($group, $route)
    {
        if (!$group) {
            return;
        }
        
        if ($this->_group) {
            $this->_route  = $this->_group . $this->_route;
            $this->_group .= $route;
            $this->_url    = substr($this->_url, 0, strlen($this->_group));
        } else {
            $this->_group  = $route;
            $this->_url    = substr($this->_url, 0, strlen($this->_route));
        }
    }
    
    
    /**
     * Verify if has parameters in route and format the route/url
     * 
     * @param string $route
     * @param string $uri
     * @return void
     */
    public function hasparam($route, $uri)
    {
        if (!strripos($route, '{')) {
            return false;
        }
        
        $this->_route       = explode('/{', $route)[0];
        $this->_param_route = explode(',', str_replace('}', '', explode('{', $route)[1]));
        $this->_url         = array_filter(explode('/', $this->_url));
        
        foreach ($this->_param_route as $value) {
            if (substr($value, -1) != '?' && $this->_url) {
                $this->_param_url[] = end($this->_url);
                array_pop($this->_url);
            } else if (substr($value, -1) == '?') {
                $this->_optional_param += 1;
            }
        }
        
        $optional_param_array = 0;
        while ($this->_optional_param) {
            if (implode('/', $this->_url) != $this->_route) {
                $this->_param_url[] = end($this->_url);
                array_pop($this->_url);
            } else {
                $optional_param_array += 1;
            }
            
            $this->_optional_param -= 1;
        }
        
        $this->_param_url = array_reverse($this->_param_url);
        
        for ($i = 0; $i < $optional_param_array; $i++) {
            $this->_param_url[] = false;
        }
        
        $this->_url = implode('/', $this->_url);
    }
    
    
    /**
     * Verify if has where and where clause is valid 
     * 
     * @return bool
     */ 
    public function hasWhere()
    {
        if (!$this->_where || !$this->_param_route || !Route::$_valid_param_url) {
            return true;
        }
        
        foreach ($this->_param_route as $key => $value) {
            if (isset($this->_where[$value]) && $this->_where[$value] && isset(Route::$_valid_param_url[$key]) && Route::$_valid_param_url[$key]) {
                $conditions = explode('|', $this->_where[$value]);
                
                foreach ($conditions as $condition) {
                    if (!Validation::make(Route::$_valid_param_url[$key], $condition)) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    
    /**
     * Verify if should treat the caracters uppercase and lowercase
     * 
     * @return void
     */
    public function hasUppercase()
    {
        if (Route::$uppercase) {
            return;
        }
        
        $this->_route = strtolower($this->_route);
        $this->_url   = strtolower($this->_url);
    }
    
    
    /**
     * Verify if has middleware for authentication
     * 
     * @return bool
     */
    public function hasMiddleware()
    {
        if (static::$_middleware && !static::$_valid_call) {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * Execute all functions inside middleware
     * 
     * @return bool
     */
    public function authMiddleware()
    {
        foreach (static::$_middleware as $auth => $call) {
            static::$verifyValidation = $auth;
            $call();
        }
                
        if (!static::$verifyValidation) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * Verify auth validation
     * 
     * @return void
     */
    public function verifyValidation()
    {
        $auth = require( __DIR__ . '/../../../App/Config/auth.php');
        
        if (!static::$verifyValidation) {
            return false;
        }
        
        foreach ($auth['users'] as $key_user => $value_user) {
            if ($key_user == static::$verifyValidation && !Session::has($key_user)) {
                $instance = new $value_user['middleware']();
                $instance->redirect();
            }
        }
        
        return true;
    }
    
    
    /**
     * Verify if the URL equals the route
     * 
     * @param string $route
     * @param string $uri
     * @return bool
     */
    public function isURL($route, $uri)
    {
        if (($this->_route === $this->_url || $this->_route === '/' . $this->_url) && count($this->_param_url) === count($this->_param_route)) {
            Route::$currentURL = $this->_route . implode('/', $this->_param_url);
            return true;
        }
        
        $this->clearParams($route);
        return false;
    }
    
    
    /**
     * Clear all params of Route class
     * 
     * @paran string $route
     * @return void
     */ 
    public function clearParams($route = false)
    {
        $this->_optional_param  = 0;
        $this->_url             = null;
        $this->_route           = null;
        $this->_param_url       = [];
        $this->_param_route     = [];
        $this->_where           = [];
        
        if ($route) {
            $this->_group = str_replace($route, '', $this->_group);
        }
    }
}