<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>JS obfuscation</title>
</head>
<body>
	<form action="/Script/upload.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>JS file dowload form</legend>
			<input type="text" name="secret_word" placeholder="your personal key"> Encryption key<br>
			<input type="file" name="js_load" accept="application/javascript"><br>
			<input type="radio" name="function_encrypt" value="1" checked="checked">Encrypt functions<br>
			<input type="radio" name="function_encrypt" value="0">Do not encrypt functions <br>
			<textarea name="func_exceptions" cols="50" rows="5" placeholder="function names separated by comma that has to be skipped during encrypting process. Leave this field blank if you chosen 'Do not encrypt functions' option."></textarea><br>
			<input type="submit" name="upload_button" value = "upload">
		</fieldset>
	</form>
	<h2><?php echo $_SESSION['Title']; ?></h2>
	<b><?php echo $_SESSION['WordErr']; ?></b>
	<b><?php echo $_SESSION['LoadErr']; ?></b>
</body>
</html>
<?php
$_SESSION = [];
session_destroy();
?>