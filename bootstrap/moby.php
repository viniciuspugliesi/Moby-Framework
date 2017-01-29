<?php

/*
| -------------------------------------------------------------------
|  Console
| -------------------------------------------------------------------
|   
|   Instance the new Console and stores in status variable
|
*/
$status = new Console\Console($argv);


/*
| -------------------------------------------------------------------
|  RUN console
| -------------------------------------------------------------------
|   
|   Execute console with run function
|
*/
return $status->run();