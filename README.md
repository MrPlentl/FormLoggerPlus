# FormLoggerPlus
### Cause sometimes I just need a File Logging Solution

### Always Under Development
I'm always adding new stuff. Though everything checked in should work... theoretically.

SETUP
### Included in __config.php
define("Log_Path",              "./_logz");
    == Location of the General Log files
define("Sql_Log_Path",          "./_logz");
    == Location of the SQL Log files
define("Usertrack_Log_Path",    "./_logz/usertracks");
    == Location of the Usertrack files
define("Util_Log_Path",         "./_logz");
    == Location of the Utility Log files
define("TraceMode",             1);	          //0: Trace() deactivated; 1: Trace() activiated
    == Turn on Trace mode when debugging. This will make use of the Trace function
define("Usertrack_Available",   1);	          //0: Trace() deactivated; 1: Trace() activiated
    == When Usertrack is turned on, additional individual ip_address logging will occur

# Method List ###
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

## License

All files are published using [GNU General Public License (GPL) version 3](https://www.gnu.org/licenses/license-list.html#GNUGPL).
I'm guessing I picked the right one, but basically, I don't care what you do with this code.


## The FileLogger Team

There is no "I" in Team... but in this case, it's just me. :) My FileLogger Class is currently maintained by [Brandon Plentl](https://github.com/MrPlentl),

## Thank you!

I really appreciate all kinds of feedback and contributions. Let me know if any of this is useful!