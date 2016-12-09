<?php
/*************************************************************
 * File:            Log2File.php
 * Function:        Contains all of the Logging info and functions to create logs
 * Author:          Brandon Plentl (bp)
 * Environment:     PhpStorm - Windows 10
 * Code Cleaned:    12/07/16 - Started
 * Code Validated:  12/07/16 - Working
 * Code Updated:    12/07/16 - Working
 * Notes:
 * Revisions:       1.00  05/07/15 (bp) First Release
 *                  2.00  12/09/16 (bp) Converted this into a Composer Library
*************************************************************/

namespace FormLoggerPlus;

require_once(__DIR__ . "/../__config.php");
### Included in log2file_config.php
//define("Log_Path",              "./_logz");
//define("Sql_Log_Path",          "./_logz");
//define("Usertrack_Log_Path",    "./_logz/usertracks");
//define("Util_Log_Path",         "./_logz");
//define("TraceMode",             1);	          //0: Trace() deactivated; 1: Trace() activiated
//define("Usertrack_Available",   1);	          //0: Trace() deactivated; 1: Trace() activiated


# Method List ###
// function History( $item );
// function UtilLog( $item );
// function LogInput();
// function LogServerInfo();
// function Trace( $item );
// SQLHistoryLog( $SqlScript );
// function ErrorLog ( $item, $logSessionInfo=FALSE );
// function ErrorSessionLog();
// function send_error_notification()

class Log2File
{
    protected function Create_htaccess()
    {
        if (file_exists(Log_Path."/.htaccess") == FALSE) {
            $filePathGen  = Log_Path."/.htaccess";                // Log_Path defined in log2file_config.php
            $file_res = fopen($filePathGen, "a");
            fwrite($file_res, sprintf("%s\r\n\t%s\r\n\t%s\r\n%s", "<Directory>", "Order allow,deny", "deny from all", "</Directory>"));
            fclose($file_res);
        }
    }

    ### History() is the actual call to write to the daily log
    ###           Use this for High Level tracking
    public function History( $item )
    {
        // Takes a variable or String to be added to the History Log: Log_Path/Log_20120908.txt
        // Example Output: 08:47:43 [127.0.0.1] Entering Run status

        // Make Log Directory
        if (file_exists(Log_Path) == FALSE) {
            mkdir(Log_Path, 0700, TRUE);   // Log_Path defined in log2file_config.php
        }

        // Make an .htaccess that will deny users access to the _logz directory and everything below
        if (file_exists(Log_Path."/.htaccess") == FALSE) {
            $this->Create_htaccess();
        }

        // General Log
        // The Collect All history log. Every log call will be written to this file
        $filePathGen  = sprintf("%s/HistoryLog_%s.txt", Log_Path, date("ymd") );   // Log_Path defined in log2file_config.php
        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s [%s] %s\r\n", date("H:i:s"), $_SERVER['REMOTE_ADDR'], $item));
        fclose($file_res);

        // If available, add the History note item to the Usertrack log as well
        if(Usertrack_Available===TRUE) {
            $this->Usertrack_Log( $item );
        }
    }

    ### Usertrack_Log() creates a daily for each user
    public function Usertrack_Log( $item )
    {
        // Make Log Directory
        if (file_exists(Usertrack_Log_Path) == FALSE) {
            mkdir(Usertrack_Log_Path, 0700, TRUE);
        }
        // The Collect All history log. Every log call will be written to this file
        $filePathGen  = sprintf("%s/%s_%s.txt", Usertrack_Log_Path, $_SERVER['REMOTE_ADDR'], date("ymd") );   // File Name Example: 127.0.0.1_140919.txt
        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s %s\r\n", date("H:i:s"), $item));   // 11:42:34 This is an item to log
        fclose($file_res);
    }

    ### ErrorLog() writes to a separate log file labeled ErrorLog; All errors also write to the main History Log
    public function ErrorLog( $item, $error_level="[WARN]", $logSessionInfo=FALSE ){
        if($logSessionInfo===TRUE) {
            //ErrorSessionLog();
        }

        // Make Log Directory
        if (file_exists(Log_Path) == FALSE){
            mkdir(Log_Path, 0700, TRUE);   // Log_Path defined in log2file_config.php
        }

        $filePathGen  = sprintf("%s/ErrorLog_%s.txt", Log_Path, date("Y") . "-" . date("W"));   // THis is currently a WEEKLY Log file
        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s [%s] %s %s\r\n", date("D d H:i:s"), $_SERVER['REMOTE_ADDR'], $error_level, $item));
        fclose($file_res);

        // Write entry to History Log
        $this->History($error_level . " " . $item);
    }

    ### UtilLog() gives the logging ability for Commandline Utility Scripts/Programs; Not meant to be used from the Browser
    public function UtilLog( $item )
    {
        // $altUser is used when using the console; This DOES NOT work from a browser. This only works from the system console
        $altUser = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  $_SERVER['USERNAME'] . "_on_" . $_SERVER['COMPUTERNAME'];   //$_SERVER['USERNAME'] and $_SERVER['COMPUTERNAME'] only work from the system console
        $Username = isset($_SESSION['Username']) && strlen($_SESSION['Username']) > 0 ?  $_SESSION['Username'] : $altUser;

        // Make Log Directory
        if (file_exists(Util_Log_Path) == FALSE) {
            mkdir(Util_Log_Path, 0700, TRUE);
        }
        // The Collect All Utility log. Every Utility log call will be written to this file
        $filePathGen  = sprintf("%s/UtilityLog_%s.txt", Util_Log_Path, date("ymd") );
        $file_res = fopen($filePathGen, "a");
        $ID = strlen($Username) > 0 ? $Username : "_Unknown";
        fwrite($file_res, sprintf("%s [%s] %s\r\n", date("H:i:s"), $ID, $item));
        fclose($file_res);
    }

    ### LogUserAgent() uses a third party to detect information about the user from the the User Agent string
    public function LogUserAgent() {
        $UserAgentURL = "useragentstring.com";   // This is the URL to the free service at useragentstring.com that reads in the User Agent Sting and parses the information; I currently only request the following: agent_name-agent_version-os_type-os_name
        // Check Connection
        if( ! fsockopen( $UserAgentURL, 80,$error_num,$error_str,2 ) ) {
            $this->ErrorLog("User Agent Values:  Unable to Log User Agent Information due to a connection error with " . $UserAgentURL . ". Error while executing: " . __METHOD__ ."() " . $error_num . " - " . $error_str, "[ERROR]");
        } else {
            $url = "http://" . $UserAgentURL . "/?uas=" . $_SERVER['HTTP_USER_AGENT'] . "&getJSON=agent_name-agent_version-os_type-os_name";
            $url = str_replace(" ", "%20", $url);   // Example: http://useragentstring.com/?uas=Mozilla/5.0%20(Windows%20NT%206.1;%20WOW64)%20AppleWebKit/537.36%20(KHTML,%20like%20Gecko)%20Chrome/37.0.2062.120%20Safari/537.36&getJSON=agent_name-agent_version-os_type-os_name

            $contents = file_get_contents($url);
            $contents = utf8_encode($contents);
            $results = json_decode($contents, true);

// EXAMPLE RETURN
//             {
//                "agent_name": "Chrome",
//                "agent_version": "37.0.2062.120",
//                "os_type": "Windows",
//                "os_name": "Windows 7"
//             }

            // Loop through and print out info
            $this->History("User Agent Values:");
            foreach ( $results as $key => $value ) {
                $this->History("   " . $key . " " . "=" . " " . $value);
            }
        }
    }

    ### LogInput() will dump any and all $_POST and/or $_GET values; there are a few custom checks in here, for instance, fields with CCnum will expert a credit card number and only print the last 4 digits
    public function LogInput()
    {
        // This will log all of the POST and GET values out to a file
        // Takes the App Name and adds it to the Log File
        /* Example Output:
        14:31:14 [_brandon] [Sysmon] -------- hardware.php --------------
        14:31:14 [_brandon] POST Values:
        14:31:14 [_brandon]    SupportLevel = Not Installed
        14:31:14 [_brandon]    level =
        14:31:14 [_brandon]    StartDate = 2006-09-05
        14:31:14 [_brandon] GET Values:
        14:31:14 [_brandon]    customerAbbr = IFP
        */

        if ( !$_POST && !$_GET ){
            $this->History("No input submitted");
        }

        if ( $_POST ) {
            $this->History("POST Values:");
            foreach ($_POST as $key => $value) {
                //  Fields that have the name 'CCnum' or AcctN will only print the last 4 characters and prepend 4 stars to its value; Meant for credit card numbers
                if (substr($key, 0, 5) == "CCnum" || substr($key, 0, 5) == "AcctN") {
                    $this->History("   " . $key . " " . "=" . " " . "****" . substr($value, -4, 4));
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $this->History("       " . $k . " " . "=" . " " . $v);
                        }
                    }
                } //  Fields that have a name that starts with 'X_' will not print any of their value to the log; instead each character will be replaced with '*'
                else if (substr($key, 0, 2) == "X_") {
                    $temp = "";
                    if (strlen($value) > 10) {
                        for ($i = 0; $i < (strlen($value) - 4); $i++) {
                            $temp .= "*";
                        }
                        $temp .= substr($value, strlen($value) - 4, 4);
                        $this->History("   " . $key . " " . "=" . " " . $temp);
                    } else {
                        for ($i = 0; $i < strlen($value); $i++) {
                            $temp .= "*";
                        }
                        $this->History("   " . $key . " " . "=" . " " . $temp);
                    }
                } // The default print to history log entry
                else {
                    $this->History("   " . $key . " " . "=" . " " . $value);
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $this->History("       " . $k . " " . "=" . " " . $v);
                        }
                    }
                }
            }
        }

        if ( $_GET ) {
            // If it's in the URL when the page submits, it will be in the log... no exceptions
            $this->History("GET Values:");
            foreach ($_GET as $key => $value) {
                $this->History("   " . $key . " " . "=" . " " . $value);
            }
        }
    }

    ### LogSession() - You generally don't want to print out SESSION information, so this should only be used for testing and debugging. This is pretty identical to the LogInput() $_POST section.
    public function LogSession()
    {
        $this->History("###############  WARNING: THIS SHOULD BE USED FOR TESTING ONLY  ########################");
        $this->History( "SESSION Values:" );
        foreach ( $_SESSION as $key => $value ){
            if( substr($key,0,5) == "CCnum" || substr($key,0,5) == "AcctN" ) {
                $this->History( "   " . $key . " " . "=" . " " . "****" . substr($value,-4,4) );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->History( "       " . $k . " " . "=" . " " . $v );
                    }
                }
            } else if( substr($key,0,2) != "X_" ) {
                $temp = "";
                if( strlen( $value ) > 10 ){
                    for( $i=0; $i<(strlen($value)-4);$i++ ){
                        $temp .= "*";
                    }
                    $temp .= substr($value,strlen($value)-4,4);
                    $this->History( "   " . $key . " " . "=" . " " . $temp );
                } else {
                    for( $i=0; $i<strlen($value);$i++ ){
                        $temp .= "*";
                    }
                    $this->History( "   " . $key . " " . "=" . " " . $temp );
                }
            } else {
                $this->History( "   " . $key . " " . "=" . " " . $value );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->History( "       " . $k . " " . "=" . " " . $v );
                    }
                }
            }
        }
    }

    ### DumpArrayToLog() will do just as it says. It will print out the array keys and values to a log. Just call the method with the array submitted
    public function DumpArrayToLog( $dump_array )
    {
        $this->History( "Array Values:" );
        foreach ( $dump_array as $key => $value ) {
            $this->History( "   " . $key . " " . "=" . " " . $value );
        }
    }

    ### Trace() is a log function where you can go overboard. 
	#           Add the trace function everywhere. 
	#           When turned on, extensive logging will take place. 
	#           Use this for testing and not everyday debugging.
    public function Trace( $item )
    {
        if( TraceMode === TRUE){
            if(Usertrack_Available===TRUE) {
                $this->Usertrack_Log( "[TRACE]" . $item );
            }
        }
    }

    ## This is just a separate log file for SQL transactions. Normally this is for INSERTS and UPDATES
    public function SQLHistoryLog( $SqlScript )
    {
        if (file_exists(Sql_Log_Path) == FALSE) {
            mkdir(Sql_Log_Path, 0700, TRUE);
        }

        $filePathGen   = sprintf("%s/SQLLog_%s.txt", Sql_Log_Path, date("ymd") );
        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s\r\n", $SqlScript ) );
        fclose($file_res);

        $this->History("[SQL Action] Check SQL Logs");
    }

    ### ErrorSessionLog() is pretty much identical to the LogInput() method except it dumps to the Error log instead. Meant for when errors occur.
    public function ErrorSessionLog()
    {
        $this->ErrorLog( "SESSION Values:" );
        foreach ( $_SESSION as $key => $value ){
            if( substr($key,0,5) == "CCnum" || substr($key,0,5) == "AcctN" ){
                $this->ErrorLog( "   " . $key . " " . "=" . " " . "****" . substr($value,-4,4) );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->ErrorLog( "       " . $k . " " . "=" . " " . $v, 1 );
                    }
                }
            }else if( substr($key,0,2) != "X_" ){
                $this->ErrorLog( "   " . $key . " " . "=" . " " . $value );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->ErrorLog( "       " . $k . " " . "=" . " " . $v, 1 );
                    }
                }
            }else{
                $temp = "";
                if( strlen( $value ) > 10 ){
                    for( $i=0; $i<(strlen($value)-4);$i++ ){
                        $temp .= "*";
                    }
                    $temp .= substr($value,strlen($value)-4,4);
                    $this->ErrorLog( "   " . $key . " " . "=" . " " . $temp );
                } else {
                    for( $i=0; $i<strlen($value);$i++ ){
                        $temp .= "*";
                    }
                    $this->ErrorLog( "   " . $key . " " . "=" . " " . $temp );
                }
            }
        }
    }
}

?>