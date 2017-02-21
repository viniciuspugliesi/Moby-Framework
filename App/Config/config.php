<?php

/*
| -------------------------------------------------------------------
|  Display Erros
| -------------------------------------------------------------------
|
|  By default, the application has the display errors true
|
*/

$DISPLAY_ERRORS = true; // false


/*
| -------------------------------------------------------------------
|  Caracter of application
| -------------------------------------------------------------------
|
|  By default, the application has the caracter UTF-8
|
*/

header('Content-Type: text/html; charset=utf-8');


/*
| -------------------------------------------------------------------
|  Base URL
| -------------------------------------------------------------------
|
|  The $baseurl is the URL required for arrive to index.php (in root 
|  of application).
|
| -------------------------------------------------------------------
|
| Obs: Never leave the index.php in $baseurl, because the file .htaccess 
|      of application ignore this.
| 
*/

$baseurl   = 'https://mobyframework-viniciuspugliesi.c9users.io/';
$localhost = false;


/*
| -------------------------------------------------------------------
|  Datetime
| -------------------------------------------------------------------
|
|  Data default in São Paulo
|
*/

date_default_timezone_set('America/Sao_Paulo');