<?php
session_start();
// variables:
$fileSize = $_FILES['js_load']['size'];
$fileExt = $_FILES['js_load']['type'];
$fileSource = $_FILES['js_load']['tmp_name'];
$newFilePath = '../../Data/JS-coded/js_coded.js';
$secretWord = $_POST['secret_word'];

$loadStatus = FALSE;

// decoding form validation
IF($_SERVER['REQUEST_METHOD']=='POST'){
	if($fileExt == 'application/javascript'){
		$fileTypeOK = TRUE;
	}else{
		$fileTypeOK = FALSE;
		$fileTypeMessage = 'You have to download JS files only'."\n";
	}
	if($fileSize <= 2000000){
		$fileSizeOK = TRUE;
	}else{
		$fileSizeOK = FALSE;
		$fileSizeMessage = 'file has to be up to 2 mb'."\n";
	}
	if($fileSize > 10){
		$fileSizeOK = TRUE;
	}else{
		$fileSizeOK = FALSE;
		$fileSizeMessage = 'You forgot to download JS coded file'."\n";
	}
	$secretWordPattern = '/[a-zA-Z0-9]/';
	if(preg_match($secretWordPattern,$secretWord)){
		$secretWordOK = TRUE;
	}else{
		$secretWordOK = FALSE;
		$secretWordMessage = 'Only letters and numbers allowed'."\n";
	}
	if($fileTypeOK == TRUE && $fileSizeOK == TRUE && $secretWordOK == TRUE){
		$loadStatus = TRUE;
	}
}

IF($loadStatus == FALSE){
	$_SESSION['FailedStatus'] = 2;
	$_SESSION['complete'] = 2;
	$_SESSION['Title'] = 'Submitted data contains errors';
	$_SESSION['WordErr'] = $secretWordMessage;
	$_SESSION['LoadErr'] = $fileTypeMessage.$fileSizeMessage;
	header('Location: ../../index.php');
	exit;
}else{
	unlink($newFilePath);
	move_uploaded_file($fileSource,$newFilePath);
	if (file_exists($newFilePath)==TRUE){
		echo "<pre>";
		echo "<h2>File downloaded sucessfully!</h2>"."\n";
		echo "<a href='../../Script/ScriptDecoder/decode.php' target='_blank'>Start Deobfuscation!</a>" ."\n";
		$_SESSION['secret_word'] = $_POST['secret_word'];
		$_SESSION['function_encrypt'] = $_POST['function_encrypt'];
		$_SESSION['variable_encrypt'] = $_POST['variable_encrypt'];
		$_SESSION['fake_data'] = $_POST['fake_data'];
		$_SESSION['newFilePath'] = $newFilePath;
	}else{
		echo "For some reasons file does not exist in specified folder";
	}
}

echo "</pre>";