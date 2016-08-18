<?php session_start() ?>
<?php $status = $_SESSION['complete'];?>
<?php $failedStatus = $_SESSION['FailedStatus']; ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>JS obfuscation</title>
</head>
<body>
<?php if($status == null || $status == 1): ?>
	<form action="/Script/ScriptCoder/upload.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>JS coder form</legend>
			<input type="text" name="secret_word" placeholder="letters and numbers only"> Encryption key<br>
			<input type="file" name="js_load" accept="application/javascript"><br>
			<input type="checkbox" name="function_encrypt" value="1" checked="checked">Encrypt functions<br>
			<input type="checkbox" name="variable_encrypt" value="1" checked="checked">Encrypt variables<br>
			<input type="checkbox" name="fake_data" value="1" checked="checked">Insert fake data<br>
			<input type="submit" name="upload_button" value = "upload">
		</fieldset>
	</form>
<?php endif; ?>

<?php
	if($status == 1 && $failedStatus == NULL){
		$file = 'Data/JS-new/js_new.js';
		$handle = fopen($file,'r');
		$code = fread($handle,filesize($file));
		echo "<h2>Your secret word is:</h2>";
		print_r($_SESSION['secret_word']);
		echo "<h2>Your link to download code is:</h2>";
		echo "<a href='Data/JS-new/js_new.js' target='_blank'>Download modified JS file</a>";
		echo "<h2>Your link to test code is:</h2>";
		echo "<a href='Tester/checkerForCoded.php' target='_blank'>Check your script</a>";
		echo "<h2>Your code is:</h2>";
		print_r($code);
	}
	if($failedStatus == 1 && $status == 1){
		echo "<pre>";
		echo"<h2>{$_SESSION['Title']}</h2>";
		echo $_SESSION['WordErr'];
		echo $_SESSION['LoadErr'];
		echo "</pre>";
	}
?>
<?php if($status == NULL || $status == 2) :?>
	<form action="/Script/ScriptDecoder/upload.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>JS decoder form</legend>
			<input type="text" name="secret_word" placeholder="letters and numbers only"> Encryption key<br>
			<input type="file" name="js_load" accept="application/javascript"><br>
			<input type="checkbox" name="function_encrypt" value="1" checked="checked">Functions were encrypted<br>
			<input type="checkbox" name="variable_encrypt" value="1" checked="checked">Variables were encrypted<br>
			<input type="checkbox" name="fake_data" value="1" checked="checked">Fake data was inserted<br>
			<input type="submit" name="upload_button" value = "upload">
		</fieldset>
	</form>
<?php endif; ?>

<?php
if($status == 2 && $failedStatus == NULL){
	$file = 'Data/JS-decoded/js_decoded.js';
	$handle = fopen($file,'r');
	$code = fread($handle,filesize($file));
	echo "<h2>Your secret word is:</h2>";
	print_r($_SESSION['secret_word']);
	echo "<h2>Your link to download code is:</h2>";
	echo "<a href='Data/JS-decoded/js_decoded.js' target='_blank'>Download decoded JS file</a>";
	echo "<h2>Your link to test code is:</h2>";
	echo "<a href='Tester/checkerForCoded.php' target='_blank'>Check your script</a>";
	echo "<h2>Your code is:</h2>";
	print_r($code);
}
if($failedStatus == 2 && $status == 2){
	echo "<pre>";
	echo"<h2>{$_SESSION['Title']}</h2>";
	echo $_SESSION['WordErr'];
	echo $_SESSION['LoadErr'];
	echo "</pre>";
}
?>

</body>
</html>
<?php
$_SESSION = [];
session_destroy();
?>