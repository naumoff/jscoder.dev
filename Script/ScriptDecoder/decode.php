<?php
session_start();
$secretWord = $_SESSION['secret_word'];
$funcEncryptStatus = $_SESSION['function_encrypt'];
$varEncryptStatus = $_SESSION['variable_encrypt'];
$fakeInsertStatus = $_SESSION['fake_data'];
$newFilePath = $_SESSION['newFilePath'];
?>
<pre>
<?php
print_r($_SESSION);

// open downloaded decoded file
$handle = fopen($newFilePath,'r');
$code = fread($handle,filesize($newFilePath));
var_dump($code);

//decoding comments part
$pattern = '/\/\*.+?\*\//';
preg_match_all($pattern,$code,$matches);
var_dump($matches);
$oldValue = $matches[0];
$count = count($oldValue)-1;
$cycle = 0;

for($cycle = 0; $cycle<=$count; $cycle++) {
	// comments decoding part
	$pattern = '/\/\*(.+)\*\//';
	if (preg_match($pattern, $matches[0][$cycle]) == 1) {
		$newValue[$cycle] = commentDecoder($oldValue[$cycle], $secretWord);
		$code = str_replace($oldValue[$cycle],$newValue[$cycle],$code);
	}
}

print_r($code);

/* bundle of functions engaged in this script*/

//comment decoder function
function commentDecoder($value,$secretWord)
{
	$pattern = '/\/\*(.+)\*\//';
	$replacer = '\1';
	$value = preg_replace($pattern,$replacer,$value);
	$value = base64_decode($value);
	var_dump($value);
	$mc_d = mcrypt_module_open(MCRYPT_BLOWFISH,'',MCRYPT_MODE_CFB,'');
	$iv_size = mcrypt_enc_get_iv_size($mc_d);
	$iv = substr($value,0,$iv_size);
	$crypt_text = substr($value,$iv_size);
	mcrypt_generic_init($mc_d,$secretWord,$iv);
	$value = mdecrypt_generic($mc_d,$crypt_text);
	mcrypt_generic_deinit($mc_d);
	$value = "/* {$value} */";
	return $value;
}

?>
</pre>