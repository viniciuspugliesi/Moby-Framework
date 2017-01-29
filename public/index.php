<?php

/*
| -------------------------------------------------------------------
|   Start in the MOBY FRAMEWORK
| -------------------------------------------------------------------
| 
|   Initialize the time of the start moby application
|
*/
define('MOBY_START', microtime(true));

/*
| -------------------------------------------------------------------
|   Calling the autoload of application
| -------------------------------------------------------------------
| 
|   In we have all the dependeces the Moby Framework initiated 
|
*/
require __DIR__ . '/../bootstrap/autoload.php';