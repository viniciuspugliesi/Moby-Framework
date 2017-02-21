<?php

namespace App\Http;

use Http\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    /**
     * Define all files route in app
     * 
     * @var array
     */
    protected $routes = [
        'default' => 'App/Http/routes.php'
    ];
    
    
    /**
     * Define all files route in app
     * 
     * @var array
     */
    protected $initClass = [
        // code
    ];
    
    
    /**
     * Define the suffix default in Controllers app
     * 
     * @var string
     */
    protected $suffixController = 'Controller';
    

    /**
     * Define configurations for initialize with app
     * 
     * @return void
     */
    public function initialize()
    {
        // code...
    }
}