<?php

/*
| -------------------------------------------------------------------
|  Session start
| -------------------------------------------------------------------
|   
|   Start in session before everything
|
*/

session_start();


/*
| -------------------------------------------------------------------
|  Autoload of application
| -------------------------------------------------------------------
|
|  Starting the autoload of application
|  Autoload pattern of PSR-4
|
*/

require __DIR__ . '/../vendor/autoload.php';


/*
| -------------------------------------------------------------------
|  Config of application
| -------------------------------------------------------------------
|
|  Starting the basic configurations of system
|  
|  Database
|  Server email
|  Format date and time
|  
*/

require __DIR__ . '/../App/Config/config.php';


/*
| -------------------------------------------------------------------
|  Curtom Error
| -------------------------------------------------------------------
|
|
*/

require __DIR__ . '/../vendor/moby/Helpers/customError.php';


/*
| -------------------------------------------------------------------
|  Redirect
| -------------------------------------------------------------------
|
|  Starting the function in redirecting the application
|  Example in call: redirec('/');
|
*/

require __DIR__ . '/../vendor/moby/Helpers/redirect.php';


/*
| -------------------------------------------------------------------
|  View
| -------------------------------------------------------------------
|
|  Starting the function returning views
|  Example in call: view('index');
|
*/

require __DIR__ . '/../vendor/moby/Helpers/view.php';


/*
| -------------------------------------------------------------------
|  URL
| -------------------------------------------------------------------
|
|  Starting the functions URL
|
*/

require __DIR__ . '/../vendor/moby/Helpers/url.php';


/*
| -------------------------------------------------------------------
|  Config of vendor
| -------------------------------------------------------------------
|
|  Starting the basic configurations of system in vendor
|  
*/

require __DIR__ . '/../vendor/moby/Config/config.php';  


/*
| -------------------------------------------------------------------
|  Console Moby
| -------------------------------------------------------------------
|
|   Verify if has console moby
|
*/

if (isset($consoleMoby)) { return; }




use Routing\Route;

/*
| -------------------------------------------------------------------
|  File routes (routes.php)
| -------------------------------------------------------------------
|
|  Including the page in routes
|
*/

require __DIR__ . '/../App/Http/routes.php';


/*
| -------------------------------------------------------------------
|  Run the applicaiton
| -------------------------------------------------------------------
|
|  Call the run application for roll in route
|
*/

Route::run();