<?php
/*************************************************************
* File:            ajax_log2file_response.php   
* Current Ver:     
* Function:       
* Author:          Brandon Plentl (bp)
* Environment:     PhpStorm - Windows 7 and iOS X
* Code Cleaned:   
* Code Validated: 
* Notes:          
* Fixes Needed:	  
* Revisions:      
*************************************************************/

require_once(__DIR__ . "/../vendor/autoload.php");   // Contains all the main logging functions

use FormLoggerPlus\Log2File;

if(isset($_GET['history_log'])&&$_GET['history_log']!="") {
    $log = new Log2File();
    $log->History($_GET['history_log']);
}