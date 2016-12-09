<?php
/*************************************************************
* File:        tester.php   
* Current Ver:     
* Function:       
* Author:         Brandon Plentl (bp)
* Environment:    PhpStorm - Windows 7
* Code Cleaned:   
* Code Validated: 
* Notes:          
* Fixes Needed:	  
* Revisions:      
*************************************************************/

require_once(__DIR__ . "/../vendor/autoload.php");   // Contains all the main logging functions

use FormLoggerPlus\Log2File;

$log = new Log2File();

//$mail = new mail();
//$mail->send_error_email("Last Test","This is the last test to Webmaster");
//echo "Writing Log File - LogUserAgent";
//$log->LogUserAgent();
//$log->History("Here is my log entry");

$log->LogUserAgent();

$log->LogInput();

$my_array = array('Web' => 'Brandon','Boss' => 'Daniel','Designer' => 'Jessica','Writer' => 'Sarah','Designer2' => 'Anthony');
$log->DumpArrayToLog($my_array);

$log->ErrorLog("This is a normal Error!");

$log->SQLHistoryLog("SELECT * FROM mytable where field=7");

$log->Trace(1);

?>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="../lib/ajax_log2file.js"></script>
</head>
<body>
<div id="div1"></div>
<?php $log->Trace(2); ?>
<form id="test" action="" method="post">
    <input type="button" id="test_button" name="test_button" value="MyButton"  />
    <input type="text" id="test_text" name="fName" placeholder="Log will track this" />
    <input type="text" id="X_test_text" name="X_test_text" placeholder="Log will not track this item" />
    <input type="text" id="CCnum" name="CCnum" placeholder="Log will not track this item" />
    <input type="checkbox" name="checkbox1" id="checkbox1" value="Checkbox 1" />Mail me more info<br />
    <input type="radio" name="radio1" id="Myradio1" value="Radio 1" />Radio 1<input type="radio" name="radio1" id="Myradio2" value="Radio 2" />Radio 2<br />
    <select name="countries" id="countries">
        <?php $log->Trace(3); ?>
        <option>Argentina</option>
        <option>Albania</option>
        <option>Afganistain</option>
        <option selected="selected">Aruba</option>
    </select>

    <input type="button" id="test_log" name="test_log" value="Do Not Click" onclick="History('This user clicked a button they were not suppose to.')"  />
    <?php $log->Trace(4); ?>
    <input type="submit" id="submit" name="submit" value="submit" />
</form>
<?php $log->Trace(5); ?>
<script type="text/javascript">
    //    $( "input[type=text]" ).blur(function(){
    //        var log;
    //        log = "LOGGING" + $(this).attr('id') + " = " + $(this).val();
    //        alert(log);
    //    });

    //$( "input[type=button]" ).click(function(){ alert("Button Clicked: "+$(this).val()); });
</script>
<?php $log->Trace(6); ?>
</body>
</html>
 