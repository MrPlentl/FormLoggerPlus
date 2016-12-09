<?php
# File:            reader.php   
# Current Ver:     
# Function:       
# Author:          Brandon Plentl (bp)
# Environment:     PhpStorm - Windows 7 and iOS X
# Code Cleaned:   
# Code Validated: 
# Notes:          
# Fixes Needed:	  
# Revisions:


$file= file_get_contents('./_logz/usertracks/127.0.0.1_160422.txt');
$lastpos = 0;
while (true) {
    usleep(300000); //0.3 s
    clearstatcache(false, $file);
    $len = filesize($file);
    if ($len < $lastpos) {
        //file deleted or reset
        $lastpos = $len;
    }
    elseif ($len > $lastpos) {
        $f = fopen($file, "rb");
        if ($f === false)
            die();
        fseek($f, $lastpos);
        while (!feof($f)) {
            $buffer = fread($f, 4096);
            echo $buffer;
            flush();
        }
        $lastpos = ftell($f);
        fclose($f);
    }
}
