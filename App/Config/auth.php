<?php

return [

        
    /*
    | -------------------------------------------------------------------
    |  Authentication users
    | -------------------------------------------------------------------
    |
    |  Here you can list users for authentication on routes and 
    |  middlewares.
    |  
    */
    
    'users' => [
        'auth' => [
            'middleware' => App\Http\Middleware\Authenticable::class,
            'model'      => App\Models\User::class
        ],
        
        'admin' => [
            'middleware' => App\Http\Middleware\Admin::class,
            'model'      => App\Models\Admin::class
        ],
        
        
    ],
];