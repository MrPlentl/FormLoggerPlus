<?php
/*************************************************************
 * File:            __config.php
 * Current Ver:     2.01
 * Function:        Contains the defined Log file locations and a couple log triggers
 * Author:          Brandon Plentl (bp)
 * Environment:     PhpStorm 2017.2 - Windows 10
 * Code Cleaned:    07/28/17 - Completed
 * Code Validated:  07/28/17 - Working
 * Code Updated:    07/28/17 - Working
 * Notes:           This is the required configuration for the Log2File Class
 * Revisions:       1.00  05/07/15 (bp) First Release
 *                  2.01  07/28/17 (bp) Second and Expected Final Release of this basic file logger
*************************************************************/

// The following Log paths can be set to Absolute Paths so you can set the path outside of the Site for security
// Currently using .htaccess to block people
define("Log_Path",              __DIR__ . "../../../../_logs");					// General Log directory
define("Sql_Log_Path",          __DIR__ . "../../../../_logs");					// This is just for the separate log file for SQL transactions. Normally this is for INSERTS and UPDATES
define("Usertrack_Log_Path",    __DIR__ . "../../../../_logs/usertracks");	    // Usertrack_Log() creates a daily log for each user
define("Util_Log_Path",         __DIR__ . "../../../../_logs");					// UtilLog() gives the logging ability for Commandline Utility Scripts/Programs; Not meant to be used from the Browser
define("JS_DIR_Path",           __DIR__ . "../../../../public/js");			    // Path to the webserver javascript folder

### Special Features ###
// Trace Mode is great for expansive logging that you might want to turn on and off from time to time without writing and deleting code
define("TraceMode",             TRUE);	          //FALSE: Trace() deactivated; TRUE: Trace() activated

// User tracks are for logging specific users. When set to TRUE, users will have their own log file along with the History log.
define("Usertrack_Available",   TRUE);	          //FALSE: Usertrack log deactivated; TRUE: Usertrack log activated