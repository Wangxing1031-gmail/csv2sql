<?php

$file_name = './uploads/'.$_POST['filename'];
$file_progress_name = $file_name . ".prg";
$retVal = @file_get_contents($file_progress_name);
if( substr($retVal, 0, 4) == "Done"){
    unlink($file_progress_name);
}
echo $retVal;

?>