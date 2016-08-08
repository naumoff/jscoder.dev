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
	move_uploaded_file($fileSource,$newFilePath);
	if (file_exists($newFilePath)==TRUE){
		echo "<pre>";
		echo "<a href='../Tester/checker.php' target='_blank'>Check your script</a>"."\n";
		echo "File downloaded sucessfully!"."\n";
	}else{
		var_dump(is_uploaded_file($newFilePath));
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
//print_r($_SERVER['REQUEST_METHOD']);
echo "</pre>";