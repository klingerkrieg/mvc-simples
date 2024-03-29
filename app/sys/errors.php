<?php

$errStyleDisplay = "<style>.codeError{padding:20px;font-size:18px;background-color:#fff4ce;border:1px solid red;}</style>";


function error_handler($code, $message, $file, $line) {
    global $errStyleDisplay, $DEBUG_MODE;

    if ($DEBUG_MODE) {
        print $errStyleDisplay;
        print "<pre class='codeError' style='border:none;'>";
        print("Code:".$code."\n");
        print("Message:".$message."\n");
        print("File:".$file."\n");
        print("Line:".$line."\n");
        print "</pre>";
    }
}

set_error_handler('error_handler');


function exception_handler($e) {    
    $errors = array(
        E_USER_ERROR        => "User Error",
        E_USER_WARNING      => "User Warning",
        E_USER_NOTICE       => "User Notice",
    );
    
    global $errStyleDisplay, $DEBUG_MODE;
    if ($DEBUG_MODE) {
        print $errStyleDisplay;
        print "<pre class='codeError'>";
        if (isset($errors[$e->getCode()])){
            print_r($errors[$e->getCode()]);
        }
        print($e->getMessage().' in '.$e->getFile().' on line '.$e->getLine()."\n");
        print_r($e->getTraceAsString());
        print_r($e);
        print "</pre>";
    }
}



set_exception_handler('exception_handler');