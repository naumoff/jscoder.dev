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
			<input type="text" name="secret_word"> Secret word<br>
			<input type="file" name="js_load" accept="application/javascript"><br>
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