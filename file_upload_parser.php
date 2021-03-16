<?php

set_time_limit(0);

$target_dir = __DIR__ . "/uploads/";
$new_file_name = date('Y_m_d_h_i_s_') . basename($_FILES["file1"]["name"]);
$target_file = $target_dir . $new_file_name;
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
/*
   // the response function
   function verbose($ok=1,$info=""){
    // failure to upload throws 400 error
    if ($ok==0) { http_response_code(400); }
    die(json_encode(["ok"=>$ok, "info"=>$info]));
 }
 // invalid upload
 if (empty($_FILES) || $_FILES['file1']['error']) {
    verbose(0, "Failed to move uploaded file. Please retry again.");
 }
 // upload destination
//  $filePath = __DIR__ . DIRECTORY_SEPARATOR . "uploads";
//  if (!file_exists($filePath)) {
//     if (!mkdir($filePath, 0777, true)) {
//        verbose(0, "Failed to create $filePath");
//     }
//  }
//  $fileName = $target_file;
 $filePath = $target_file;
 // dealing with the chunks
 $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
 $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
 $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
 if ($out) {
    $in = @fopen($_FILES['file1']['tmp_name'], "rb");
    if ($in) {
       while ($buff = fread($in, 4096)) { fwrite($out, $buff); }
    } else {
       verbose(0, "Failed to open input stream");
    }
    @fclose($in);
    @fclose($out);
    @unlink($_FILES['file1']['tmp_name']);
 } else {
    verbose(0, "Failed to open output stream");
 }
 // check if file was uploaded
 if (!$chunks || $chunk == $chunks - 1) {
    rename("{$filePath}.part", $filePath);
 }
 verbose(1, "Upload OK"); 
 */



// Check tmp file
if( !file_exists($_FILES["file1"]["tmp_name"])){
  echo "Sorry, temp file is not exists.";
  $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file1"]["size"] > 1000000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  // print_r($_FILES["file1"]["tmp_name"]);
  if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
    echo htmlspecialchars( $new_file_name );
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>