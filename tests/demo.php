<?php
/*************************************************************
 * File:            demo.php
 * Function:        A basic demo of the FormLoggerPlus controls
 * Author:          Brandon Plentl (bp)
 * Environment:     PhpStorm - Windows 10
 * Code Cleaned:    12/07/16 - Started
 * Code Validated:  12/07/16 - Working
 * Code Updated:    12/07/16 - Working
 * Notes:
 * Revisions:       1.00  05/07/15 (bp) First Release
 *                  2.00  12/09/16 (bp) Converted this into a Composer Library
 *************************************************************/

require_once(__DIR__ . "/../vendor/autoload.php");   // Contains all the main logging functions
use FormLoggerPlus\Log2File;

$log = new Log2File();

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
</body>
</html>
 