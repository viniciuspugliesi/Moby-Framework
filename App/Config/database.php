<?php

return [
    
    /*
    | -------------------------------------------------------------------
    |  File configuration of database
    | -------------------------------------------------------------------
    |
    |  With the array $database, you can place all connections with database
    |
    |  With the variable $default you speat what database should be used default for connection
    |
    */
    
    'default' => 'mysql',
     
    
    /*
    | -------------------------------------------------------------------
    |  CONNECTION MYSQL
    | -------------------------------------------------------------------
    |   
    |   If your connection is MySQL, set all attributes below
    |
    */
    
    'mysql' => [
        'host'      => '',
        'user'      => '',
        'pass'      => '',
        'database'  => '',
        'charset'   => 'utf8',
        'dns'       => 'mysql' // My SQL
    ],
        
        
    /*
    | -------------------------------------------------------------------
    |  CONNECTION SQLSERVER
    | -------------------------------------------------------------------
    |
    |   If your connection is SqlServer, set all attributes below
    |
    */
    
    'sqlserver' => [
        'host'      => '',
        'user'      => '',
        'pass'      => '',
        'database'  => '',
        'charset'   => 'utf8',
        'dns'       => 'sqlserver' // SQL SERVER
    ],
        
        
    /*
    | -------------------------------------------------------------------
    |  CONNECTION ORACLE
    | -------------------------------------------------------------------
    |
    |   If your connection is Oracle, set all attributes below
    |
    */
    
    'oracle' => [
        'host'      => '',
        'user'      => '',
        'pass'      => '',
        'database'  => '',
        'charset'   => 'utf8',
        'dns'       => 'oracle' // oracle
    ],
];