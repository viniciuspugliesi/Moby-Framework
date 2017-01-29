<?php

/*
| -------------------------------------------------------------------
|  BASEURL
| -------------------------------------------------------------------
|
|  Sets config base url
|
*/

$GLOBALS['BASEURL']         = $BASEURL;
$GLOBALS['localhost']       = $localhost;


/*
| -------------------------------------------------------------------
|  Maintenance Web-site
| -------------------------------------------------------------------
|
|  Make sure the site is under maintenance
|
*/

if (App\Exceptions\ConfigException::$maintenance) {
    App\Exceptions\ConfigException::maintenanceWebsite();
    die();
}



/*
| -------------------------------------------------------------------
|  Show errors
| -------------------------------------------------------------------
|
|  Set display errors and errors reporting
|
*/

ini_set('display_errors', 0);

if ($DISPLAY_ERRORS) {
    ini_set('error_reporting', E_ALL);
} else {
    ini_set('error_reporting', 0);
}