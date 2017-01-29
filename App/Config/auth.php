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
            'middleware' => App\Http\Middleware\Auth::class,
            'Model'      => App\Models\User::class
        ],
        
        // 'admin' => [
        //     'middleware' => App\Http\Middleware\Admin::class,
        //     'Model'      => App\Models\Admin::class
        // ],
        
        
    ],
];