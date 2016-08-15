<?php
session_start();

// variables:
$fileSize = $_FILES['js_load']['size'];
$fileExt = $_FILES['js_load']['type'];
$fileSource = $_FILES['js_load']['tmp_name'];
$newFilePath = '../JS-old/js_old.js';
$secretWordPattern = '/[a-z]+/i';

$loadStatus = NULL;

// Error messages sent to index.php in case of Errors
$secretWordErr = NULL;
$fileLoadErr = NULL;

IF($_SERVER['REQUEST_METHOD']=='POST'){
	
	
}

IF($loadStatus == 'FAILED'){
	error($secretWordErr,$fileLoadErr);
}else{
	unlink($newFilePath);
	move_uploaded_file($fileSource,$newFilePath);
	if (file_exists($newFilePath)==TRUE){
		echo "<pre>";
		echo "<h2>File downloaded sucessfully!</h2>"."\n";
		echo "<a href='../Script/create.php' target='_blank'>Start Obfuscation!</a>"."\n";
		$_SESSION['secret_word'] = $_POST['secret_word'];
		$_SESSION['function_encrypt'] = $_POST['function_encrypt'];
		$_SESSION['variable_encrypt'] = $_POST['variable_encrypt'];
		$_SESSION['fake_data'] = $_POST['fake_data'];
	}else{
		echo "For some reasons file does not exist in specified folder";
	}
}

function error($secretWordErr,$fileLoadErr)
{
	$_SESSION['Title'] = 'Submitted data contains errors';
	$_SESSION['WordErr'] = $secretWordErr;
	$_SESSION['LoadErr'] = $fileLoadErr;
	header('Location: ../index.php');
	exit;
}

//print_r($_FILES);
//print_r($_POST);
echo "</pre>";