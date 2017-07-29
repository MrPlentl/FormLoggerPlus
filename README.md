FileLoggerPlus
=====================
### Cause sometimes you just need a quick and easy File Logging Solution
The main purpose of this class is to log not just from the server side, but also from the client side, but more so especially when using forms. As the user fills out a form and they move from input to input, the FileLogger will write the field data/value to the log file.

#### Log File Sample
```
10:52:06 User Click  -> [test_button] => MyButton
10:52:07 User Entry [text]      -> [test_text] => Brandon
10:52:08 User Entry [text]      -> [X_test_text] => ** Not Tracking **
10:52:09 User Entry [text]      -> [CCnum] => ****4685
10:52:09 User Entry [checkbox]  -> [checkbox1] => Checkbox 1
10:52:11 User Entry [radio]     -> [Myradio2] => Radio 2
10:52:12 User Entry [radio]     -> [Myradio1] => Radio 1
10:52:13 User Entry [select]    -> [countries] Drop Down Selected => Albania
```
Features
---
* Separate files for History, Errors, SQL, and User Logs
* Log entries from the Server side and Client browser side
* Toggle Trace logging On and Off for low level code logging when needed
* Easy to deploy


Quick Setup
---
### Out of the box, place the FileLoggerBasic folder at the root and just add a require path to the Log2File.class.php file
* require_once("FileLoggerBasic/Log2File.class.php");
* NOTE: jQuery is REQUIRED for the front end logging
* HINT: THere is a demo.php file included that will let you play with the functionality as well.

## Version 2 Available NOW
I just finished what I plan to be the final version of this basic logging format. I will be working on my FormLoggerPlus from here on out that will be far more robust and use the more convenient composer install. 

SETUP
-----
### Included in __config.php
The following Log paths can be set to Absolute Paths so you can set the path outside of the Site for security
Currently using .htaccess to block people
```
define("Log_Path",              "../_logs");                // General Log directory
define("Sql_Log_Path",          "../_logs");                // This is just for the separate log file for SQL transactions. Normally this is for INSERTS and UPDATES
define("Usertrack_Log_Path",    "../_logs/usertracks");     // Usertrack_Log() creates a daily log for each user
define("Util_Log_Path",         "../_logs");                // UtilLog() gives the logging ability for Commandline Utility Scripts/Programs; Not meant to be used from the Browser
```

#### Special Features
* Trace Mode is great for expansive logging that you might want to turn on and off from time to time without writing and deleting code
define("TraceMode",             TRUE);	          //FALSE: Trace() deactivated; TRUE: Trace() activated
* User tracks are for logging specific users. When set to TRUE, users will have their own log file along with the History log.
define("Usertrack_Available",   TRUE);	          //FALSE: Usertrack log deactivated; TRUE: Usertrack log activated

#### Method List
```
function History( $item );
    == General Log files
function UtilLog( $item );
    == Utility Log files - Used for primarily for local CLI scripts
function LogInput();
    == Logs any and all $_POST and/or $_GET values; Fields with CCnum will only print the last 4
function LogServerInfo();
function Trace( $item );
SQLHistoryLog( $SqlScript );
function ErrorLog ( $item, $logSessionInfo=FALSE );
function ErrorSessionLog();
function send_error_notification()
```

## License

All files are published using [GNU General Public License (GPL) version 3](https://www.gnu.org/licenses/license-list.html#GNUGPL).
I'm guessing I picked the right one, but basically, I don't care what you do with this code.


## The FileLogger Team
There is no "I" in Team... but in this case, it's just me. :) My FileLoggerBasic Class is currently maintained by [Brandon Plentl](https://github.com/MrPlentl),

## Thank you!
I really appreciate all kinds of feedback and contributions. Let me know if any of this is useful!