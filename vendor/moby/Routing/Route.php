<?php

namespace Routing;

use Http\Request;
use Routing\System;
use Routing\ValidationRoute;
use Exception\RenderException;
use Routing\Interfaces\InterfaceRoute;

/**
 * Class of application routes (GET, POST, PUT, DELETE)
 *
 */
class Route extends ValidationRoute implements InterfaceRoute
{
    /**
     * Considered or not characters capitalized route or URL
     *
     * @var bool
     */
	public static $uppercase = true;
    
    
    /**
     * Navigatior URL 
     *
     * @var string
     */
	protected $_url;
    
    /**
     * Route pass URL for application
     *
     * @var string
     */
	protected $_route;
    
    /**
     * Method for call
     *
     * @var string
     */
	protected $_call;
    
    /**
     * Method for valid call
     *
     * @var array
     */
    protected static $_valid_call;
    
    /**
     * Routes group
     *
     * @var string
     */
	protected $_group;
    
    /**
     * Parameters of route pass for the application
     *
     * @var string
     */
	protected $_param_route;
    
    /**
     * Where clause of route pass for the application
     *
     * @var where
     */
	protected $_where = [];
    
    /**
     * Parameters of url of navigator
     *
     * @var array
     */
	protected $_param_url = [];
    
    /**
     * Parameters valid of url of navigator
     *
     * @var array
     */
    protected static $_valid_param_url = [];
    
    /**
     * Parameters optionals in URL
     *
     * @var int
     */
    protected $_optional_param = 0;
    
    /**
     * Middleware of the route
     *
     * @var string
     */
    protected static $_middleware = [];
    
    /**
     * Current URL
     * 
     * @var string
     */ 
    protected static $currentURL = '';
    
    /**
     * Verify if has validation
     * 
     * @var bool OR string
     */ 
    protected static $verifyValidation = false;
    
    
    /**
     * Function that receive all types requests
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $this
     */
	public static function any($route, $call)
    {
        $instance = new static();
        
        if (!$instance->validar_url($route, $call)) {
            return $instance;
        }
        
        $instance->verifyValidation();
        
        $instance->setValidParams($call, $instance->_param_url);
        return $instance;
    }
    
    
    
    /**
     * Function that receive request type GET
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $this
     */
	public static function get($route, $call)
    {
        $instance = new static();
        
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return $instance;
        }
        
        if (!$instance->validar_url($route, $call)) {
            return $instance;
        }
        
        $instance->verifyValidation();
        
        $instance->setValidParams($call, $instance->_param_url);
        return $instance;
    }
    
    
    
    /**
     * Function that receive request type POST
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $this
     */
	public static function post($route, $call)
    {
        $instance = new static();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $instance;
        }
        
        if (!$instance->validar_url($route, $call)) {
            return $instance;
        }
        
        $instance->verifyValidation();
        
        $instance->setValidParams($call, $instance->_param_url);
        return $instance;
    }
    
    
    
    /**
     * Function that receive request type PUT
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $this
     */
	public static function put($route, $call)
    {
        $instance = new static();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return $instance;
        }
        
        if (!$instance->validar_url($route, $call)) {
            return $instance;
        }
        
        $instance->verifyValidation();
        
        $instance->setValidParams($call, $instance->_param_url);
        return $instance;
    }
    
    
    
    /**
     * Function that receive request type DELETE
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $this
     */
	public static function delete($route, $call)
    {
        $instance = new static();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return $instance;
        }
        
        if (!$instance->validar_url($route, $call)) {
            return $instance;
        }
        
        $instance->verifyValidation();
        
        $instance->setValidParams($call, $instance->_param_url);
        return $instance;
        
    }
    
    
    
    /**
     * Function that group the routes
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $call()
     */
	public static function group($route, $call)
    {
        $instance = new static();
        
        if (!is_object($call)) {
            return $instance;
        }
        
        if (!$instance->validar_url($route, $call, true)) {
            return $instance;
        }
        
        return $call();
    }
    
    
    
    /**
     * Function that authenticates the routes
     *
     * @param string $route (route)
     * @param string $call (method)
     * @return $call()
     */
	public static function middleware($auth, $call = false)
    {
        $instance = new static();
        
        if (!is_object($call)) {
            return $instance;
        }
        
        static::$_middleware[$auth] = $call;
        
        return $instance;
    }
    
    
    
    /**
     * Function that name the route
     *
     * @param string $name
     * @return void
     */
	public function name($name)
    {
        $this;
        
    }
    
    
    
    /**
     * Set uppercase in the route
     *
     * @param bool $upper
     * @return void
     */
	public static function setUppercase($upper)
    {
        try {
            if (!is_bool($upper)) {
                throw new RenderException('Expected boolean in the [setUppercase] function and received ' . gettype($upper), 1002);
            }
            
            static::$uppercase = $upper;
        } catch (RenderException $e) {
            $e->render($e->showErrors(), $e);
        }
    }
    
    
    
    /**
     * Function that where the route
     *
     * @param array $where
     * @return void
     */
	public function where(array $where)
    {
        $this->_where = $where;
        
        if (!$this->hasWhere() && $this->_route === $this->_url && count($this->_param_url) === count($this->_param_route)) {
            $this->clearparams();
            
            static::$_valid_param_url = [];
            static::$_valid_call      = '';
        }
        
        return $this;
    }
    
    
    
    /**
     * Function runs the route
     * 
     * @return new instance controller
     */
    public static function run()
    {
        $instance = new static();
        
        try {
            if ($instance->hasMiddleware() && !$instance->authMiddleware() || !static::$_valid_call) {
                throw new RenderException('Route not found', 1001);
            }
            
            Request::setCurrentURL(static::$currentURL);
            
            if (is_object(static::$_valid_call)) {
                return call_user_func_array(static::$_valid_call, static::$_valid_param_url);
            }
            
            return System::run(static::$_valid_call, static::$_valid_param_url);
        } catch (RenderException $e) {
            $e->render($e->routeNotFound(), $e);
        }
    }
}