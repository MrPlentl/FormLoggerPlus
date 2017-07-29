<?php
/*************************************************************
 * File:            ajax_log2file_response.php
 * Current Ver:     2.01
 * Function:        This is for using the form micro logging that monitor the users interactions with a form
 * Author:          Brandon Plentl (bp)
 * Environment:     PhpStorm 2017.2 - Windows 10
 * Code Cleaned:    07/28/17 - Completed
 * Code Validated:  07/28/17 - Working
 * Code Updated:    07/28/17 - Working
 * Notes:           This is the just for the response to the ajax call
 * Revisions:       1.00  05/07/15 (bp) First Release
 *                  2.01  07/28/17 (bp) Second and Expected Final Release of this basic file logger
 *************************************************************/

require_once(__DIR__ . "/../vendor/autoload.php");   // Contains all the main logging functions

use FormLoggerPlus\Log2File;

if(isset($_GET['history_log'])&&$_GET['history_log']!="") {
    $log = new Log2File();
    $log->History($_GET['history_log']);
}